import { destroy, get, patch, post } from "@/composable/useApi.js";

// API URL për raportimet
const API_URL = 'http://127.0.0.1:8000/api';

// Fetch për datat
export async function fetchPerDate() {
  try {
    const response = await get(`${API_URL}/perdate`);
    if (response && response.data) {
      return response.data;
    }
    return null;
  } catch (e) {
    console.error("Gabim gjatë marrjes së të dhënave për datat:", e);
    return null;
  }
}

// Fetch për shitjet totale
export async function fetchShitjetTotale() {
  try {
    const response = await get(`${API_URL}/shitjetTotale`);
    if (response && response.data) {
      return response.data;
    }
    return null;
  } catch (e) {
    console.error("Gabim gjatë marrjes së shitjeve totale:", e);
    return null;
  }
}

// Fetch për raportet për javën
export async function fetchPerJaven() {
  try {
    const response = await get(`${API_URL}/java`);
    if (response && response.data) {
      return response.data;
    }
    return null;
  } catch (e) {
    console.error("Gabim gjatë marrjes së të dhënave për javën:", e);
    return null;
  }
}

// Fetch për raportet për muajin
export async function fetchPerMuajin() {
  try {
    const response = await get(`${API_URL}/muaji`);
    if (response && response.data) {
      return response.data;
    }
    return null;
  } catch (e) {
    console.error("Gabim gjatë marrjes së të dhënave për muajin:", e);
    return null;
  }
}

// Fetch për raportet për periudhën e datave
export async function fetchShitjetPerDate(startDate, endDate) {
  try {
    const response = await get(`${API_URL}/data-fillimit/between/datambarimit`, {
      params: { startDate, endDate },
    });
    if (response && response.data) {
      return response.data;
    }
    return null;
  } catch (e) {
    console.error("Gabim gjatë marrjes së të dhënave për periudhën e datave:", e);
    return null;
  }
}


export async function ShitjeTotald() {
    try {
      const response = await get(`${API_URL}/shitjetTotale`, {
        params: { startDate, endDate },
      });
      if (response && response.data) {
        return response.data;
      }
      return null;
    } catch (e) {
      console.error("Gabim gjatë marrjes së të dhënave për periudhën e datave:", e);
      return null;
    }
  }


  