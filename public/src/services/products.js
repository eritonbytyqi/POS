import {destroy, get, patch, post} from "@/composable/useApi.js";
const API_URL = 'http://127.0.0.1:8000/api'; // Vendosni URL-në e API-së tuaj

export async function getProducts(pageQuery = '', filters = {}) {
  try {
      const response = await get('api/produktet', { params: filters }); // Përdorimi i GET për kërkimin
      if (response.status === 200) {
          return response.data;
      }
      return null;
  } catch (e) {
      console.error('Gabim gjatë marrjes së produkteve:', e);
      return null;
  }
}

export async function showProduct(id) {
  try {
      console.log("product ID:", id); 
      console.log("API URL:", 'api/produktet/' + id); 
      
      return await get('api/produktet/' + id).then(res =>{
              if(res.status === 200){
                  return res.data;
              }
              return null
          }
      );
  }catch (e) {
      return null;
  }
}
// export async function storeProduct(form) {
//   try {
//     const response = await post('api/produktet', form);

//     // Kontrollo nëse ka përgjigje dhe kthe një rezultat të saktë
//     if (response && response.data) {
//       console.log("Store Product Response:", response);
//       return response.data;  // Kthe të dhënat e produktit të ruajtur
//     } else {
//       console.error("No data returned from storeProduct API.");
//       return null;
//     }
//   } catch (error) {
//     console.error("Error in storeProduct:", error);
//     return null;
//   }
// }

export const fetchProducts = async (folderId) => {
  try {
    // Dërgo kërkesën në API për produktet në folderin e specifikuar
    const response = await get(`${API_URL}/folders/${folderId}/products`);
    
    // Kontrollo nëse 'data' është në përgjigje
    if (response && response.data) {
      return response.data;  // Kthe të dhënat nëse ekziston 'data'
    } else {
      console.error('Përgjigja nga API nuk ka të dhëna:', response);
      throw new Error('Përgjigja nuk ka të dhëna');
    }
  } catch (error) {
    console.error('Gabim gjatë marrjes së produktet:', error);
    throw error; // Rishfaq gabimin
  }
};
export async function updateProduct(id, form) {
  try {
     
      const response = await patch(`api/produktet/${String(id)}`, form);
      if (response.status === 200) {
          return response.data;
      }
      return null;
  } catch (e) {
      console.error("Error updating doctor:", e);
      return null;
  }
}

export async function deleteProduct(id) {
  try {
      return await destroy('api/produktet/' + id).then(res =>{
              if(res.status === 200){
                  return res;
              }
              return null
          }
      );
  }catch (e) {
      return null;
  }
}
export async function fetchProduktet(searchQuery) {
  try {
    // Sigurohuni që URL-ja është e saktë
    const response = await axios.post('/api/produktet/veqmas', { search: searchQuery });

    if (response.status === 200 && Array.isArray(response.data)) {
      return response.data; // Kthe produktet që janë gjetur
    }
    return null; // Nëse nuk janë gjetur produkte
  } catch (e) {
    console.error('Gabim gjatë kërkimit të produktit:', e);
    return null;
  }
}

// Store product in subfolder
export async function storeProductInSubfolder(form, folderId, subfolderId) {
  try {
    // Make sure folderId and subfolderId are not undefined
    if (!folderId || !subfolderId) {
      throw new Error('Invalid folderId or subfolderId');
    }

    const response = await post(`/api/folders/${folderId}/subfolders/${subfolderId}/products`, form);

    // Check if response is valid and contains data
    if (response && response.data) {
      return response.data;
    } else {
      throw new Error("Invalid response structure");
    }
  } catch (error) {
    console.error("Error adding product:", error);
    throw error;
  }
};
