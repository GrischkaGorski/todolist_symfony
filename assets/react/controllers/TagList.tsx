import React, { useEffect, useState } from 'react';
import {Tag} from "./TodoList";
import TagItem from "../components/TagItem";
import Link from "./Link";

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

  const saveNewTag = async (newTagName: string, tagId: number): Promise<void> => {
    try {
      const res = await fetch(`/api/tags/${tagId}`, {
        method: 'PATCH',
        headers: {
          'Accept': 'application/ld+json',
          'Content-Type': 'application/merge-patch+json'
        },
        body: JSON.stringify({ name: newTagName })
      });
    } catch (error) {
      console.error(error);
    }
  };

  const deleteTag = async (tagId: number): Promise<void> => {
    try {
      const res = await fetch(`/api/tags/${tagId}`, {
        method: 'DELETE',
      });
      const updatedTags = tags.filter(tag => tag.id !== tagId);

      setTags(updatedTags);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchTags();
  }, []);

  return (
    <div className="flex flex-col gap-8">
      <div className="flex flex-col gap-5">
        {tags?.length > 0 && (
          <ul className="flex gap-5 flex-wrap">
            {tags.map(tag => (
              <TagItem key={tag.id} tag={tag} saveNewTag={saveNewTag} deleteTag={deleteTag}/>
            ))}
          </ul>
        )}
      </div>
      <div>
        <Link color="blue" href="/" text="Accueil"/>
      </div>
    </div>
  );
}
