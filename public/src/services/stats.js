import { get } from "@/composable/useApi.js";

// Fetch doctors count
export async function getDoctorsCount() {
    try {
      const response = await get('api/doctors'); 
      console.log('Doctors response:', response);  
      if (response.status === 200) {
        return response.data.result.data.length; 
      }
      return 0;
    } catch (error) {
      console.error('Error fetching doctors:', error);
      return 0;
    }
  }
  
