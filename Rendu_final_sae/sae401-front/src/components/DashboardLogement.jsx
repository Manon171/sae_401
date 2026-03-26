

import React, { useEffect, useState } from 'react';
import { Line, Bar, Bubble, Doughnut, Pie } from 'react-chartjs-2';
import { getData } from '../services/api';
import { ArcElement } from 'chart.js';
import {
  Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement,
  BarElement, Title, Tooltip, Legend
} from 'chart.js';


ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, BarElement, Title, Tooltip, Legend, ArcElement);


const DashboardLogement = () => {
  const [data, setData] = useState([]);
  const labelsAnnees = [2021, 2022, 2023];


  const targetDepts = {
    'Dordogne': { code: '24', color: '#007bff' },
    'Jura': { code: '39', color: '#28a745' },
    'Paris': { code: '75', color: '#dc3545' },
    'Rhône': { code: '69', color: '#fd7e14' },
    'Seine-et-Marne': { code: '77', color: '#6f42c1' },
    'Vosges': { code: '88', color: '#6c757d' }
  };


  useEffect(() => {
    getData().then(res => {
      console.log("Premier objet reçu :", res[0]);
      setData(res);
    }).catch(err => console.error("Erreur API :", err));
  }, []);


  if (!data || data.length === 0) {
    return <div style={{textAlign: 'center', color: 'white', padding: '50px'}}>Chargement des graphiques...</div>;
  }


  const prepareDataset = (type) => {
    return Object.keys(targetDepts).map(deptName => {
      const config = targetDepts[deptName];
     
      const deptStats = data.filter(item => {
        const itemCode = String(item.codeDepartement || item.codedepartement || "");
        return itemCode.trim() === String(config.code);
      });
     
      return {
        label: deptName,
        data: labelsAnnees.map(annee => {
          const entry = deptStats.find(s => Number(s.anneePublication) === Number(annee));
         
          if (!entry) return 0;
         
          let val = 0;
          if (type === 'vacants') {
            val = entry.tauxLogementsVacants;
          } else if (type === 'densite') {
            val = entry.densitePopulation;
          } else if (type === 'ratio') {
            const soc = parseFloat(entry.tauxLogementsSociaux || 0);
            const dens = parseFloat(entry.densitePopulation || 1);
            val = dens > 0 ? (soc / dens) : 0;
          }
         
          const finalVal = parseFloat(val);
          return isNaN(finalVal) ? 0 : finalVal;
        }),
        borderColor: config.color,
        backgroundColor: config.color,
        tension: 0.3,
        pointRadius: 6,
        pointHoverRadius: 8
      };
    });
  };


  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: '30px', maxWidth: '1000px', margin: '0 auto', padding: '20px' }}>
     
      <div style={{ background: '#fff', padding: '20px', borderRadius: '10px', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }}>
        <h2 style={{ color: '#333', textAlign: 'center', marginBottom: '20px' }}>Taux de logement vacant (%)</h2>
        <Line data={{ labels: labelsAnnees, datasets: prepareDataset('vacants') }} />
      </div>


      <div style={{ background: '#fff', padding: '20px', borderRadius: '10px', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }}>
        <h2 style={{ color: '#333', textAlign: 'center', marginBottom: '20px' }}>Densité de population (hab/km²) en 2023</h2>
       
        {/*  une seule année (2023) */}
        <Pie
          data={{
            labels: Object.keys(targetDepts),
            datasets: [{
              data: prepareDataset('densite').map(dataset => dataset.data[2]),
              backgroundColor: Object.values(targetDepts).map(d => d.color)
            }]
          }}
        />
      </div>


      <div style={{ background: '#fff', padding: '20px', borderRadius: '10px', boxShadow: '0 4px 6px rgba(0,0,0,0.1)' }}>
        <h2 style={{ color: '#333', textAlign: 'center', marginBottom: '20px' }}>Ratio Logements Sociaux / Densité</h2>
        <Bar data={{ labels: labelsAnnees, datasets: prepareDataset('ratio') }} />
      </div>


    </div>
  );
};


export default DashboardLogement;
