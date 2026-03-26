import { useState } from 'react';
import { postData } from '../services/api'; // ⚠️ corriger le chemin

function Form() {
  const [nom, setNom] = useState('');

  const handleSubmit = () => {
    postData({ nom }).then(() => {
      alert('Ajout réussi');
    });
  };

  return (
    <div>
      <input
        value={nom}
        onChange={(e) => setNom(e.target.value)}
        placeholder="Nom"
      />
      <button onClick={handleSubmit}>Envoyer</button>
    </div>
  );
}

export default Form;