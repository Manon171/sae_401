function Home() {
  return (
    <div style={{ maxWidth: "800px", margin: "0 auto", padding: "20px", textAlign: "left" }}>
     
      <h2 style={{ marginBottom: "40px" }}>
        Bienvenue sur la page d'accueil
      </h2>


      <p>
        Cette interface permet de visualiser et comparer plusieurs indicateurs liés au logement à travers différents départements.
      </p>


      <p>
        Les graphiques présentés permettent notamment d’explorer :
      </p>


      <ul style={{ paddingLeft: "20px" }}>
        <li>l’évolution du <strong>taux de logements vacants</strong> sur plusieurs années,</li>
        <li>la <strong>densité de population</strong> par département pour une année donnée,</li>
        <li>ainsi que le rapport entre logements sociaux et densité de population.</li>
      </ul>


      <p>
        Ces visualisations permettent de comparer les territoires et mieux comprendre les dynamiques locales du logement.
      </p>


    </div>
  );
}


export default Home;