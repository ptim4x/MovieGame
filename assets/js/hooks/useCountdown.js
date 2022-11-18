import { useState, useEffect } from "react";

export function useCountdown(default_count) {
  const [countdown, setCountdown] = useState(default_count);

  // componentDidMount like
  useEffect(() => {
    const interval = setInterval(() => {
      setCountdown((countdown) => (countdown > 0 ? countdown - 1 : countdown));
    }, 1000);
    return () => clearInterval(interval);
  }, []);

  return [countdown, setCountdown];
}
