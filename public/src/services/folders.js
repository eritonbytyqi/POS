import { get, post } from '@/composable/useApi';
import axios from 'axios'; // Importoni axios për të bërë kërkesa HTTP

const API_URL = 'http://127.0.0.1:8000/api'; // Vendosni URL-në e API-së tuaj

// Funksioni për të marrë të gjithë folderat
export const getFolders = async () => {
  try {
    const response = await axios.get(`${API_URL}/folders/main`);
    return response.data;
  } catch (error) {
    console.error('Error fetching folders:', error);
    throw error;
  }
};

export const getAllFoldersAndSubfolders = async () => {
  try {
    const response = await get(`${API_URL}/folders/all`);
    return response.data || [];
  } catch (error) {
    console.error('Gabim gjatë marrjes së të gjithë folderëve dhe subfolderëve:', error);
    return [];
  }
};

export const addProductToSubfolder = async (folderId, subfolderId, productData) => {
  try {
    const response = await post(`${API_URL}/folders/${folderId}/subfolders/${subfolderId}/products`, productData);
    return response.data || {};
  } catch (error) {
    console.error('Gabim gjatë shtimit të produktit në subfolder:', error);
    return {};
  }
};




export const fetchFolderProducts = async (folderId) => {
  try {
    const response = await axios.get(`${API_URL}/folders/${folderId}/products`);
    return response.data || [];
  } catch (error) {
    console.error('Gabim gjatë marrjes së produkteve të folderit:', error);
    return [];
  }
};

export const fetchProducts = async (folderId, subfolderId) => {
  try {
    const response = await axios.get(`${API_URL}/folders/${folderId}/subfolders/${subfolderId}/products`);
    return response.data || [];
  } catch (error) {
    console.error('Gabim gjatë marrjes së produkteve të subfolderit:', error);
    return [];
  }
};

// Funksioni për të krijuar një folder të ri


// Example of how the data should look when you make the API request
export const storeFolder = async (folderName) => {
  try {
    const response = await axios.post(`${API_URL}/folders`, {
      name: folderName, // Make sure 'name' is passed
    });
    return response.data;
  } catch (error) {
    console.error('Error creating folder:', error);
    throw error;
  }
};

// Funksioni për të krijuar një nënfolder
export const storeSubfolder = async (folderId, subfolderName) => {
  try {
    const response = await post(`${API_URL}/folders/add/${folderId}/subfolders`, { name: subfolderName });
    
    // Verifikoni nëse përgjigja është në formatin e pritur
    if (response && response.data) {
      return response.data;
    } else {
      console.error('Përgjigja nga serveri është e papritur:', response);
      throw new Error('Përgjigja nga serveri është e papritur');
    }
  } catch (error) {
    console.error('Gabim gjatë krijimit të subfolderit:', error);
    throw error;
  }
};

export const getSubfolders = async (folderId) => {
  try {
    const response = await axios.get(`${API_URL}/folders/${folderId}/subfolders`);
    return response.data || [];
  } catch (error) {
    console.error('Gabim gjatë marrjes së subfolderave:', error);
    return [];
  }
};
export const updateSubfolder = async (subfolderId, newName) => {
  try {
    const response = await axios.put(`${API_URL}/subfolders/${subfolderId}`, { name: newName });
    return response.data;
  } catch (error) {
    console.error('Gabim gjatë përditësimit të subfolderit:', error);
    return null;
  }
};
export const updateFolder = async (folderId, newName) => {
  try {
    const response = await axios.put(`${API_URL}/subfolders/${folderId}`, { name: newName });
    return response.data;
  } catch (error) {
    console.error('Gabim gjatë përditësimit të subfolderit:', error);
    return null;
  }
};


export const deleteFolder = async (folderId) => {
  try {
    const response = await axios.delete(`${API_URL}/folder/${folderId}`);
    console.log("Përgjigja nga serveri:", response.data);
    return response.data;
  } catch (error) {
    console.error('Gabim gjatë fshirjes së folderit:', error.response?.data || error);
    return null;
  }
};
export const deleteSubfolder = async (subfolderId) => {
  try {
    const response = await axios.delete(`${API_URL}/subfolder/${subfolderId}`);
    console.log("Përgjigja nga serveri:", response.data);
    return response.data;
  } catch (error) {
    console.error('Gabim gjatë fshirjes së subfolderit:', error.response?.data || error);
    return null;
  }
};

// Funksioni për të shtuar një produkt në një folder
export const addProductToFolder = async (folderId, productId) => {
  try {
    // Dërgojmë kërkesën për të lidhur produktin me folderin
    const response = await post(`${API_URL}/folders/${folderId}/products`, { productId });
    return response.data; // Kthejmë të dhënat për produktin e shtuar në folder
  } catch (error) {
    console.error('Error adding product to folder:', error);
    throw error;
  }
};
export const storeSubfolderInSubfolder = async (parentFolderId, subfolderId, subfolderData) => {
  try {
    const response = await post(`${API_URL}/folders/${parentFolderId}/subfolder/${subfolderId}`, subfolderData);
    return response.data || {};
  } catch (error) {
    console.error('Gabim gjatë ruajtjes së subfolder-it brenda subfolder-it:', error);
    return {};
  }
};

