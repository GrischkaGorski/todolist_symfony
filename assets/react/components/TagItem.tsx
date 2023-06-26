import React from 'react';
import {Tag} from "../controllers/TodoList";
import {RxCross2} from "react-icons/rx";
import {AiFillEdit} from "react-icons/ai";

interface TodoItemProps {
  tag: Tag;
}

export default function TagItem({ tag }: TodoItemProps) {
  return (
    <li
      className="rounded-md border border-slate-200 shadow shadow-slate-200 hover:bg-blue-50">
      <div className="flex flex-col text-center gap-4 p-4">
        <span className="text-md font-bold uppercase px-2 py-1 text-blue-700">
           {tag.name}
        </span>
        <div className="text-slate-600 font-bold flex gap-4 px-4">
          Tâches :
          <span>{tag.todos.length}</span>
        </div>
        <div className="flex px-4 justify-between">
          <AiFillEdit className="h-6 w-6 text-yellow-300 hover:text-yellow-500 hover:cursor-pointer"/>
          <RxCross2 onClick={} className="h-6 w-6 text-red-600 hover:text-red-900 hover:cursor-pointer"/>
        </div>
      </div>
    </li>
  )
}
