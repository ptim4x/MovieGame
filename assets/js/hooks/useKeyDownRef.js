import { useEffect, useRef } from "react";

/**
 * Handle key press as shortcut to run method (default: click) on ref related element
 *
 * @param {string|Array} keyDown
 * @param {string} method
 * @returns ref
 */
const useKeyDownRef = (keyDown, method = "click") => {
  const targetRef = useRef(null);

  useEffect(() => {
    const keyDownHandler = (event) => {
      if (
        (Array.isArray(keyDown) && keyDown.includes(event.key)) ||
        event.key === keyDown
      ) {
        targetRef.current[method]();
      }
    };

    document.addEventListener("keydown", keyDownHandler);

    return () => document.removeEventListener("keydown", keyDownHandler);
  }, []);

  return targetRef;
};

export default useKeyDownRef;
