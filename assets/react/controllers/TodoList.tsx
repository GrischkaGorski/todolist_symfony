import React, {useEffect, useState} from 'react';

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

export default function TodoList() {
  const [todos, setTodos] = useState<Todo[]>([]);

  const fetchTodos = async (): Promise<void> => {
    try {
      const response = await fetch("https://localhost/api/todos");
      const data = await response.json();
      setTodos(data["hydra:member"]);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchTodos();
  }, []);

  return (
    <>
      {todos?.length > 0 && (
        <ul className="flex flex-col gap-5">
          {todos.map(todo => (
            <li
              key={todo.id}
              className="w-full rounded-md border border-slate-200 shadow shadow-slate-200 p-4 hover:bg-blue-50 hover:cursor-pointer">
              <div className="flex">
                <div className="w-4/5">
                  <div>
                    <p className="text-slate-600">{todo.title}</p>
                    {todo.description && (
                      <p className="text-sm font-italic text-slate-400">{todo.description}</p>
                    )}
                  </div>
                  {todo.tags.length > 0 &&
                    <div className="flex gap-2 mt-4">
                      {todo?.tags?.map(tag => (
                        <span key={tag.id} className="text-2xs font-bold uppercase px-2 py-1 bg-blue-200 text-blue-700 rounded-full">
                          {tag.name}
                        </span>
                      ))}
                    </div>
                  }
                </div>
                <div className="w-1/5 flex justify-center items-center">
                  <p className="uppercase text-sm font-bold text-slate-400">
                    {todo.done ? "Fait" : "À faire"}
                  </p>
                </div>
              </div>
            </li>
          ))}
        </ul>
      )}
    </>
  )
}
