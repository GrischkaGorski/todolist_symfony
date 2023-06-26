import React, { useEffect, useState } from 'react';
import {Tag} from "./TodoList";
import TagItem from "../components/TagItem";

export default function TagList(): JSX.Element {
  const [tags,setTags] = useState<Tag[]>([]);

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


  console.log(tags)
  return (
    <div className="flex flex-col gap-5">
      {tags?.length > 0 && (
        <ul className="flex gap-5 flex-wrap">
          {tags.map(tag => (
            <TagItem key={tag.id} tag={tag}/>
          ))}
        </ul>
      )}
    </div>
  );
}
