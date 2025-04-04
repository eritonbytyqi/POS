<template>  
  <div>
    <Navbar />
    <HomeSection />
    <AboutSection />
    <DepartmentsSection />
    <!-- <BookAppointmentSection /> -->
    
    <!-- Shfaqja e mesazhit të suksesit -->
    <div v-if="$route.query.appointmentSuccess" class="alert alert-success">
      <p>Your appointment was created successfully!</p>
    </div>

    <BlogSection />
    <DoctorsSection />
    <ContactSection />
    <FooterSection />
  </div>

</template>

<script>
import Navbar from "@/components/Landing/Navbar.vue";
import HomeSection from "@/components/Landing/HomeSection.vue";
import AboutSection from "@/components/Landing/AboutSection.vue";
import DepartmentsSection from "@/components/Landing/DepartmentsSection.vue";
// import BookAppointmentSection from "@/components/Landing/BookAppointmentSection.vue";
import BlogSection from "@/components/Landing/BlogSection.vue";
import DoctorsSection from "@/components/Landing/DoctorsSection.vue";
import ContactSection from "@/components/Landing/ContactSection.vue";
import FooterSection from "@/components/Landing/FooterSection.vue";

export default {
  components: {
    Navbar,
    HomeSection,
    AboutSection,
    DepartmentsSection,
    // BookAppointmentSection,
    BlogSection,
    DoctorsSection,
    ContactSection,
    FooterSection,
  },
  mounted() {
    if (this.$route.query.appointmentSuccess) {
      console.log("Takimi është krijuar me sukses!");
    }
  },
};
</script>

<style scoped>
/* Për opsionin e mesazhit */
.alert {
  background-color: #d4edda;
  color: #155724;
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 5px;
  border: 1px solid #c3e6cb;
}
</style>
