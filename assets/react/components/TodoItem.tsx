import React from 'react';
import {Todo} from "../controllers/TodoList";
import {RxCross2} from "react-icons/rx";
import {AiFillEdit} from "react-icons/ai";

interface TodoItemProps {
  todo: Todo;
  saveNewTodo: (newDoneValue: boolean, todoId: number) => Promise<void>;
  deleteTodo: (todoId: number) => Promise<void>;
}

export default function TodoItem({ todo, saveNewTodo, deleteTodo}: TodoItemProps) {
  const handleDoneToggle = () => {
    const newDoneValue = !todo.done;
    saveNewTodo(newDoneValue, todo.id);
  }

  const handleDeleteTodo = () => {
    deleteTodo(todo.id)
  }

  const colorVariants: { [key: string]: string } = {
    true: 'text-slate-200 hover:text-slate-900',
    false: 'text-red-700 hover:text-red-900',
  };

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
          <div className="w-1/5 flex justify-between items-center">
            <p onClick={handleDoneToggle} className={`${colorVariants[String(todo.done)]} w-1/3 text-center uppercase text-sm font-bold hover:cursor-pointer`}>
              {todo.done ? "Fait" : "À faire"}
            </p>
            <a href={`/todos/edit/${todo.id}`} className="w-1/3 text-slate-400 hover:text-slate-900 hover:cursor-pointer">
              <AiFillEdit className="m-auto"/>
            </a>
            <RxCross2 onClick={handleDeleteTodo} className="w-1/3 h-5 text-slate-400 hover:text-slate-900 hover:cursor-pointer"/>
          </div>
        </div>
    </li>
  )
}
