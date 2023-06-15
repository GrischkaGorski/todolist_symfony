import React, {Dispatch, FormEvent, SetStateAction} from 'react';
import {Todo} from "../controllers/TodoList";

type TodosFilterProps = {
  todos: Todo[]
  setFilteredTodos: Dispatch<SetStateAction<Todo[]>>
}

export default function TodosFilter({todos, setFilteredTodos}: TodosFilterProps) {
  const handleDoneFilter = (event: FormEvent<HTMLDivElement>) => {
    const value = (event.target as HTMLInputElement).value;

    if ( value === 'true' ) {
      setFilteredTodos(todos.filter(todo => todo.done))
    } else if ( value === 'false') {
      setFilteredTodos(todos.filter(todo => !todo.done))
    } else {
      setFilteredTodos(todos)
    }
  }

  return (
    <div onChange={(event) => handleDoneFilter(event)} className="flex items-center gap-2 px-5">
      <div >
        <input id="done-filter" type="radio" value="true" name="done"
               className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        <label htmlFor="default-radio-1" className="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Faits</label>
      </div>
      <div>
        <input id="not-done-filter" type="radio" value="false" name="done"
               className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        <label htmlFor="default-radio-2" className="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">À faire</label>
      </div>
      <div>
        <input defaultChecked={true} id="not-done-filter" type="radio" value='' name="done"
               className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
        <label htmlFor="default-radio-2" className="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tous</label>
      </div>
    </div>
  )
}
