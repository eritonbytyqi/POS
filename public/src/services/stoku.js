import {destroy, get, patch, post} from "@/composable/useApi.js";

export async function getStock(pageQuery = '', filters = {}) {
    try {

        return await get('api/stoku' + pageQuery, {params: filters}).then(res =>{
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
export async function showStok(id) {
  try {
      console.log("product ID:", id); 
      console.log("API URL:", 'api/stoku/' + id); 
      
      return await get('api/stoku/' + id).then(res =>{
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
export async function storeStoku(form) {
  try {
    const response = await post('api/stoku', form);

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

export async function updateStock(id, form) {
  try {
     
      const response = await patch(`api/stoku/${String(id)}`, form);
      if (response.status === 200) {
          return response.data;
      }
      return null;
  } catch (e) {
      console.error("Error updating doctor:", e);
      return null;
  }
}

// export async function deleteShitje(id) {
//   try {
//       return await destroy('api/shitjet/' + id).then(res =>{
//               if(res.status === 200){
//                   return res;
//               }
//               return null
//           }
//       );
//   }catch (e) {
//       return null;
//   }
// }