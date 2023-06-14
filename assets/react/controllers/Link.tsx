import React from 'react';

interface Props {
  text: string
}

export default function (props: Props) {
    const { text } = props;
    return (
        <a
          href="/todos/create"
          className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-4 py-2 focus:outline-none">
          {text}
        </a>
    )
}
