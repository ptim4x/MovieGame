import { useEffect, useRef } from "react";

/**
 * Hook that handle key press and release as shortcut to run 
 * method (default: click) on ref related element
 *
 * @param {string|Array} keyboardShortcut
 * @param {string} method
 * @returns ref to plug on related element
 */
const useKeyboardShortcutRef = (keyboardShortcut, method = "click") => {
  const targetRef = useRef(null);

  useEffect(() => {
    const keyboardShortcutHandler = (event) => {
      if (
        (Array.isArray(keyboardShortcut) && keyboardShortcut.includes(event.key)) ||
        event.key === keyboardShortcut
      ) {
        targetRef.current[method]();
      }
    };

    document.addEventListener("keyup", keyboardShortcutHandler);

    return () => document.removeEventListener("keyup", keyboardShortcutHandler);
  }, []);

  return targetRef;
};

export default useKeyboardShortcutRef;
