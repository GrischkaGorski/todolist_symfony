import React from 'react';

interface Props {
  text: string
  href: string
  color: 'blue' | 'red' | 'green'
}

export default function (props: Props) {
    const { text, href, color } = props;

    const colorVariants:{[key in Props['color']]: string} = {
      blue: 'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300',
      red: 'bg-red-700 hover:bg-red-800 focus:ring-red-300',
      green: 'bg-green-700 hover:bg-green-800 focus:ring-green-300',
    }

    return (
        <a
          href={href}
          className={`${colorVariants[color]} text-white focus:ring-4 font-medium rounded-md text-sm px-5 py-2.5 focus:outline-none`}
        >
          {text}
        </a>
    )
}
