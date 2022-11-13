import React from "react";
import Game from "./game/Game";

function App() {
  return (
    <div className="container align-center">
      <header className="mb-5">
        <h1 className="text-bg-info text-center p-3">
          Test de connaissance cinématographique
        </h1>
      </header>
      <main className="text-center">
        <Game />
      </main>
      <footer className=""></footer>
    </div>
  );
}

export default App;
