import axios from '../axios';

export function fetchData(endpoint, params) {
  return axios.get(endpoint, { params });
}

export function postData(endpoint, data) {
  return axios.post(endpoint, data);
}