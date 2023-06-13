import React from 'react';

interface Props {
  test: string
}

export default function (props: Props) {
    const { test } = props;
    return (
      <p>{test}</p>
    )
}
