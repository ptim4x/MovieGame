import { useState, useEffect } from "react";

/**
 * Hook to manage images pre loading
 */
const useImagesLoading = () => {
  const [loadingImages, setImagesLoading] = useState([]);
  const [isLoading, setLoading] = useState(false);

  const cacheImages = async (srcArray) => {
    setLoading(true);

    let imagesCount = srcArray.length;

    const promises = srcArray.map(async (src) => {
      return new Promise(function (resolve, reject) {
        const img = new Image();

        img.src = src;
        img.onload = resolve();
        img.onerror = reject();

        // Finish loading one image
        img.onloadend = () => {
          if (--imagesCount === 0) {
            setLoading(false);
          }
        };
      });
    });

    await Promise.all(promises);
  };

  useEffect(() => {
    // Preload images each time loadingImages change and is not empty
    if (loadingImages.length > 0) {
      cacheImages(loadingImages);
    } else {
      setLoading(false);
    }
  }, [loadingImages]);

  return [isLoading, setImagesLoading];
};

export default useImagesLoading;
