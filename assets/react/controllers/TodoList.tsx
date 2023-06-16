import React, {useCallback, useEffect, useState} from 'react';
import Link from "./Link";
import TodoItem from "../components/TodoItem"
import TodosFilter from "../components/TodosFilter";

export interface Todo {
  id: number;
  title: string;
  description?: string;
  done: boolean;
  tags: Tag[];
}

export interface Tag {
  id: number;
  name: string;
}

export default function TodoList() {
  const [todos, setTodos] = useState<Todo[]>([]);
  const [filteredTodos, setFilteredTodos] = useState<Todo[]>([])

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

  useEffect(() => {
    setFilteredTodos(todos)
  }, [todos])

  const handleFilterChange = useCallback((filter: { checkedTags: string[], doneFilter: string }) => {
    const { checkedTags, doneFilter } = filter;

    const filteredTodos = todos.filter(todo =>
      checkedTags.every(checkedTag =>
        todo.tags.some(tag => tag.id.toString() === checkedTag)
      )
    ).filter(todo => {
      if (doneFilter === 'true') {
        return todo.done;
      } else if (doneFilter === 'false') {
        return !todo.done;
      } else {
        return true;
      }
    });

    setFilteredTodos(filteredTodos);

  }, [todos]);

  return (
    <div className="flex flex-col gap-5">
      <div className="flex justify-between">
        <Link text="Nouveau" href="/todos/create" color="blue"/>
        <TodosFilter handleFilterChange={handleFilterChange}/>
      </div>
      {filteredTodos?.length > 0 && (
        <ul className="flex flex-col gap-5">
          {filteredTodos.map(todo => (
            <TodoItem key={todo.id} {...todo}/>
          ))}
        </ul>
      )}
    </div>
  )
}
