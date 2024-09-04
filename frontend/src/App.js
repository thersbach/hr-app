import React, { useEffect, useState } from 'react';
import axios from "axios";

function App() {
  const [employees, setEmployees] = useState([]);
  const [transports, setTransports] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    axios.get('http://localhost:8000/api/employees')
        .then(response => {
          setEmployees(response.data["hydra:member"]);
        })
        .catch(error => console.error(error));

    axios.get('http://localhost:8000/api/transports')
        .then(response => {
          setTransports(response.data["hydra:member"]);
        })
        .catch(error => console.error(error));
  }, []);

  if (!employees || !employees.length) return (<p>Loading...</p>);

  return (
      <div className={"container pt-5"}>
        <h1>Employee Travel distance calculator</h1>

        <table className={"table"}>
          <thead>
            <tr>
              <th>Name</th>
              <th>Workdays</th>
              <th>Distance From Home (km)</th>
              <th>Transport</th>
            </tr>
          </thead>
          <tbody>
          {employees.map(employee => (
              <tr key={employee.id}>
                <td>{employee.name}</td>
                <td>{employee.workdays}</td>
                <td>{employee.distanceFromHome}</td>
                <td>{transports.find(transport => transport["@id"] === employee.transport)?.name}</td>
              </tr>
          ))}</tbody>
        </table>

        <button class={"btn btn-primary"}
                disabled={loading}
               className={"btn btn-primary"}
               onClick={() => {
                  setLoading(true)
                  axios.get('http://localhost:8000/api/calculate')
                  .then(response => {
                    // redirect to export api
                    window.location.href = 'http://localhost:8000/api/export';
                  })
                  .catch(error => alert(error))
                  .finally(() => setLoading(false));
                }}
              >
          {loading ? <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>:""}
          Calculate and export
        </button>
      </div>
  );
}

export default App;
