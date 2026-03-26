
import React from "react";
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";


import Home from "./pages/home";
import Graphs from "./pages/graphe";


import "./App.css";


function App() {
  return (
    <Router>
      <div className="App">
       
        <header className="navbar">
          <h1 className="logo">Appli graphes</h1>


          <nav className="nav-links">
            <Link to="/">Accueil</Link>
            <Link to="/graphs">Graphes</Link>
          </nav>
        </header>


        {/* CONTENU */}
        <main className="content">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/graphs" element={<Graphs />} />
          </Routes>
        </main>


        {/* FOOTER */}
        <footer className="footer">
          <p>2026 - Analyse des statistiques de logement</p>
        </footer>


      </div>
    </Router>
  );
}
export default App;