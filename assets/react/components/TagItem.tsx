import React, {ChangeEvent, useEffect, useState} from 'react';
import {Tag} from "../controllers/TodoList";
import {RxCross2} from "react-icons/rx";
import {useDebounce} from "../hooks/useDebounce";

interface TodoItemProps {
  tag: Tag;
  saveNewTag: (newTagName: string, tagId: number) => Promise<void>;
  deleteTag: (tagId: number) => Promise<void>;
}

export default function TagItem({ tag, saveNewTag, deleteTag}: TodoItemProps) {
  const [value, setValue] = useState<string>(tag.name)
  const debounceValue = useDebounce<string>(value, 500)

  const handleChange = (event: ChangeEvent<HTMLInputElement>) => {
    setValue(event.target.value)
  }

  useEffect(() => {
    if ( debounceValue === tag.name ) {
      return
    }
    saveNewTag(debounceValue, tag.id)
  }, [debounceValue])

  return (
    <li
      className="rounded-md border border-slate-200 shadow shadow-slate-200 hover:bg-blue-50">
      <div className="flex flex-col text-center gap-2 p-4">
        <div className="flex justify-between items-center gap-8">
          <input
            className="text-md font-bold text-blue-500 border-0 focus:outline-none bg-transparent"
            value={value}
            onChange={handleChange}
          />
          <button onClick={() => deleteTag(tag.id)}>
            <RxCross2 className="text-slate-600 hover:text-slate-900 hover:cursor-pointer"/>
          </button>
        </div>
        <p className="text-slate-400 font-bold flex flex-start">
          Tâches : {tag.todos.length}
        </p>
      </div>
    </li>
  )
}
