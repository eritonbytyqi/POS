import {destroy, get, patch, post} from "@/composable/useApi.js";

export async function getShitjet(pageQuery = '', filters = {}) {
    try {

        return await get('api/shitjet' + pageQuery, {params: filters}).then(res =>{
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
export async function showShitje(id) {
  try {
      console.log("product ID:", id); 
      console.log("API URL:", 'api/shitjet/' + id); 
      
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
export async function storeShitje(form) {
  try {
    console.log("Dërgimi i të dhënave për shitjen:", form);  // Printo të dhënat që po dërgoni
    const response = await post('api/shitjet', form);
    if (response && response.data) {
      console.log("Store Product Response:", response);
      return response.data;
    } else {
      console.error("No data returned from storeProduct API.");
      return null;
    }
  } catch (error) {
    console.error("Error in storeProduct:", error);
    return null;
  }
}


export async function updateShitje(id, form) {
  try {
     
      const response = await patch(`api/shitjet/${String(id)}`, form);
      if (response.status === 200) {
          return response.data;
      }
      return null;
  } catch (e) {
      console.error("Error updating doctor:", e);
      return null;
  }
}

export async function deleteShitje(id) {
  try {
      return await destroy('api/shitjet/' + id).then(res =>{
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