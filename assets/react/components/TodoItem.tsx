import React, {useState} from 'react';

interface Todo {
  id: number;
  title: string;
  description?: string;
  done: boolean;
  tags: Tag[];
}

interface Tag {
  id: number;
  name: string;
}

export default function TodoItem(todo: Todo) {
  const colorVariants: { [key: string]: string } = {
    true: 'text-green-400',
    false: 'text-slate-400',
  };

  const handleDoneToggle = (): void => {
    const newDoneValue = {'done' : !todo.done};
    updateDoneTodo(newDoneValue)
  };

  const updateDoneTodo = async (value: Partial<Todo>) => {
    console.log(JSON.stringify(value))
    try {
      const res = await fetch(`https://localhost/api/todos/${todo.id}`, {
        method: "post",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(value)
      })
    } catch (error) {
      console.error(error);
    }
  }

  return (
    <li
      className="w-full rounded-md border border-slate-200 shadow shadow-slate-200 p-4 hover:bg-blue-50">
      <div className="flex">
        <div className="w-4/5">
          <div>
            <p className="text-slate-600">{todo.title}</p>
            {todo.description && (
              <p className="text-sm font-italic text-slate-400">{todo.description}</p>
            )}
          </div>
          {todo.tags.length > 0 &&
            <div className="flex gap-2 mt-4 flex-wrap">
              {todo?.tags?.map(tag => (
                <span key={tag.id} className="text-2xs font-bold uppercase px-2 py-1 bg-blue-200 text-blue-700 rounded-full">
                  {tag.name}
                </span>
              ))}
            </div>
          }
        </div>
        <div className="w-1/5 flex justify-center items-center">
          <p onClick={handleDoneToggle} className={`${colorVariants[String(todo.done)]} uppercase text-sm font-bold hover:cursor-pointer`}>
            {todo.done ? "Fait" : "À faire"}
          </p>
        </div>
      </div>
    </li>
  )
}
