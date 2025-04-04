import {destroy, get, patch, post} from "@/composable/useApi.js";

export async function getKlientet(pageQuery = '', filters = {}) {
    try {

        return await get('api/klientet' + pageQuery, {params: filters}).then(res =>{
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
export async function showKlient(id) {
  try {
      console.log("product ID:", id); 
      console.log("API URL:", 'api/klientet/' + id); 
      
      return await get('api/klientet/' + id).then(res =>{
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
export async function storeKlient(form) {
  try {
    const response = await post('api/klientet', form);

    // Kontrollo nëse ka përgjigje dhe kthe një rezultat të saktë
    if (response && response.data) {
      console.log("Store Product Response:", response);
      return response.data;  // Kthe të dhënat e produktit të ruajtur
    } else {
      console.error("No data returned from storeProduct API.");
      return null;
    }
  } catch (error) {
    console.error("Error in storeProduct:", error);
    return null;
  }
}

export async function updateKlient(id, form) {
  try {
     
      const response = await patch(`api/klientet/${String(id)}`, form);
      if (response.status === 200) {
          return response.data;
      }
      return null;
  } catch (e) {
      console.error("Error updating doctor:", e);
      return null;
  }
}

export async function deleteKlient(id) {
  try {
      return await destroy('api/klientet/' + id).then(res =>{
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