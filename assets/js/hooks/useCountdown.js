import { useState, useEffect } from "react";

/**
 * Hook for countdown on related component mount
 * Count downs each second from starting_count to 0
 * 
 * @param {number} starting_count countdown starting value 
 * @returns array with value and setter
 */
const useCountdown = (starting_count) => {
  const [countdown, setCountdown] = useState(starting_count);

  // componentDidMount like
  useEffect(() => {
    const interval = setInterval(() => {
      setCountdown(countdown => countdown > 0 ? countdown - 1 : countdown);
    }, 1000);
    return () => clearInterval(interval);
  }, []);

  return [countdown, setCountdown];
}

export default useCountdown;
