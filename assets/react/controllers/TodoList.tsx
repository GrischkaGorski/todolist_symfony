import React, {useEffect, useState} from 'react';
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
      setFilteredTodos(todos)
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchTodos();
  }, []);

  useEffect(() => {
    setFilteredTodos(todos);
  }, [todos]);

  return (
    <div className="flex flex-col gap-5">
      <div className="flex justify-between">
        <Link text="Nouveau" href="/todos/create" color="blue"/>
        <TodosFilter todos={todos}  filteredTodos={filteredTodos} setFilteredTodos={setFilteredTodos} />
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
