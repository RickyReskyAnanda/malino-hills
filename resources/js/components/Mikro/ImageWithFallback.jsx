import React, { useState } from 'react';

const ImageWithFallback = ({ src, fallbackSrc, alt, ...props }) => {
  const [imgSrc, setImgSrc] = useState(src);

  const handleError = () => {
    setImgSrc(fallbackSrc);
  };

  return (
    <img
      src={imgSrc}
      alt={alt || 'Image'}
      onError={handleError}
      {...props}
    />
  );
};

export default ImageWithFallback;
