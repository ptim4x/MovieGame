import { useState, useEffect } from "react";

const getLocalStorageOrDefault = (key, defaultValue) => {
  const stored = localStorage.getItem(key);
  if (!stored) {
    return defaultValue;
  }
  return JSON.parse(stored);
}

/**
 * Hook for local storage value
 * 
 * @param {string} key the local storage string key
 * @param {string} defaultValue default value if key not exists into local storage
 * @returns array with value and setter
 */
const useLocalStorage = (key, defaultValue) => {
  const [value, setValue] = useState(
    getLocalStorageOrDefault(key, defaultValue)
  );

  useEffect(() => {
    localStorage.setItem(key, JSON.stringify(value));
  }, [key, value]);

  return [value, setValue];
}

export default useLocalStorage;
