import React, {FormEvent, useEffect, useState} from 'react';
import {Tag} from "../controllers/TodoList";

type TodosFilterProps = {
  handleFilterChange: (filter : { checkedTags: string[], doneFilter: string }) => void
}

export default function TodosFilter({handleFilterChange}: TodosFilterProps) {
  const [tags, setTags] = useState<Tag[]>([]);
  const [checkedTags, setCheckTags] = useState<string[]>([])
  const [doneFilter, setDoneFilter] = useState<string>('')

  const fetchTags = async (): Promise<void> => {
    try {
      const response = await fetch("https://localhost/api/tags");
      const data = await response.json();
      setTags(data["hydra:member"]);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchTags();
  }, []);


  const handleDoneFilter = (event: FormEvent<HTMLDivElement>) => {
    const value = (event.target as HTMLInputElement).value;
    setDoneFilter(value);
  }

  const handleTagCheck = (e: FormEvent<HTMLInputElement>) => {
    const value = (e.target as HTMLInputElement).value;
    if (!checkedTags.includes(value)) {
      setCheckTags(prev => [ ...prev, value])
    } else {
      setCheckTags(checkedTags.filter(tag => tag != value))
    }
  }

  useEffect(() => {
      handleFilterChange({checkedTags, doneFilter})
    }, [checkedTags, doneFilter]
  )

  return (
    <div className="flex items-center pl-5">
      <h2 className="h2 text-slate-600">Filtres :</h2>
      <div onChange={(event) => handleDoneFilter(event)} className="flex items-center gap-5 px-5">
        <div className="flex flex-col items-center gap-1" >
          <label htmlFor="done-filter" className="text-sm font-medium text-slate-600">Faits</label>
          <input id="done-filter" type="radio" value="true" name="done"
                 className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        </div>
        <div className="flex flex-col items-center gap-1">
          <label htmlFor="not-done-filter" className="text-sm font-medium text-slate-600">À faire</label>
          <input id="not-done-filter" type="radio" value="false" name="done"
                 className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        </div>
        <div className="flex flex-col items-center gap-1">
          <label htmlFor="not-filtered" className="text-sm font-medium text-slate-600">Tous</label>
          <input defaultChecked={true} id="not-filtered" type="radio" value='' name="done"
                 className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        </div>
      </div>
      <div className="h-full w-[1px] bg-slate-200"></div>
      <div className="pl-5">
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
          Tags
          <svg className="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div id="dropdown" className="z-10 hidden bg-white rounded-lg shadow w-fit p-5 flex flex-col gap-2">
          {tags.map((tag )=> (
            <div key={tag.id} className="flex items-center" onChange={handleTagCheck}>
              <input id={`tag-${tag.id}`} type="checkbox" value={tag.id} className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
              <label htmlFor={`tag-${tag.id}`} className="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                {tag.name}
              </label>
            </div>
          ))}
        </div>
      </div>
    </div>

  )
}
