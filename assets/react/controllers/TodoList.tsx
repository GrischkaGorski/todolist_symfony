import React, { useCallback, useEffect, useState } from 'react';
import Link from "./Link";
import TodoItem from "../components/TodoItem"
import TodosFilter from "../components/TodosFilter";
import {BsFillTrashFill} from "react-icons/bs";

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

export default function TodoList(): JSX.Element {
  const [todos, setTodos] = useState<Todo[]>([]);
  const [filteredTodos, setFilteredTodos] = useState<Todo[]>([]);
  const [filters, setFilters] = useState<{ checkedTags: string[], doneFilter: string }>({
    checkedTags: [],
    doneFilter: ''
  });

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
    filterTodos();
  }, [todos, filters]);

  const filterTodos = useCallback(() => {
    const { checkedTags, doneFilter } = filters;

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
  }, [todos, filters]);

  const handleFilterChange = useCallback((filter: { checkedTags: string[], doneFilter: string }) => {
    setFilters(filter);
  }, []);

  const saveNewTodo = async (newDoneValue: boolean, todoId: number): Promise<void> => {
    try {
      const res = await fetch(`/api/todos/${todoId}`, {
        method: 'PATCH',
        headers: {
          'Accept': 'application/ld+json',
          'Content-Type': 'application/merge-patch+json'
        },
        body: JSON.stringify({ done: newDoneValue })
      });

      const updatedTodos = todos.map(todo => {
        if (todo.id === todoId) {
          return { ...todo, done: newDoneValue };
        }
        return todo;
      });
      setTodos(updatedTodos);
    } catch (error) {
      console.error(error);
    }
  };

  const deleteTodo = async (todoId: number): Promise<void> => {
    try {
      const res = await fetch(`/api/todos/${todoId}`, {
        method: 'DELETE',
      });

      const updatedTodos = todos.filter(todo => todo.id !== todoId);

      setTodos(updatedTodos);
    } catch (error) {
      console.error(error);
    }
  };

  const deleteDoneTodos = async (): Promise<void> => {
    try {
      const res = await fetch('/api/todos/delete/done', {
        method: 'DELETE',
      });

      const updatedTodos = todos.filter(todo => !todo.done);

      setTodos(updatedTodos);
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className="flex flex-col gap-5">
      <div className="flex justify-between">
        <div className="flex gap-5">
          <Link text="Nouveau" href="/todos/create" color="blue" />
          <button className="text-slate-400 hover:text-slate-900" onClick={deleteDoneTodos}>Supprimer toutes les tâches faîtes</button>
        </div>
        <TodosFilter handleFilterChange={handleFilterChange} />
      </div>
      {filteredTodos?.length > 0 && (
        <ul className="flex flex-col gap-5">
          {filteredTodos.map(todo => (
            <TodoItem key={todo.id} todo={todo} saveNewTodo={saveNewTodo} deleteTodo={deleteTodo}/>
          ))}
        </ul>
      )}
    </div>
  );
}
