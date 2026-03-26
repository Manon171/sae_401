import axios from "axios";

export const getData = () => {
  // Ajoute bien le "/" à la fin de logement/ pour correspondre au PHP
  return axios.get("https://127.0.0.1:8000/statistique/logement/")
    .then(response => {
      console.log("DATA DANS AXIOS :", response.data);
      return response.data;
    })
    .catch(error => {
      console.error("ERREUR AXIOS :", error);
      throw error;
    });
};