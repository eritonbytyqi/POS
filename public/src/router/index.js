import { createRouter, createWebHistory } from 'vue-router';
import FolderView from '@/views/folders.vue';
import AppLayout from '@/views/Layout/AppLayout.vue';
import CreateProduct from '@/views/produktet/Create.vue';
import Stoku from '@/views/Stoku/index.vue';
import Klientet from '@/views/Klientet/index.vue';
import EditKlienti from '@/views/Klientet/Edit.vue';
import CreateKlient from '@/views/Klientet/Create.vue';
import Shitjet from '@/views/Shitjet/index.vue';
import EditShitja from '@/views/Shitjet/Edit.vue';
import CreateShitje from '@/views/Shitjet/Create.vue';
import CreateStok from '@/views/Stoku/Create.vue';
import raportimet from '@/views/Raportimet/raportimet.vue';


const routes = [
  {
    path: '/',
    name: 'Layout',
    component: AppLayout,
    children: [
      {
        path: 'folders', // Kjo rrugë tani është relative
        name: 'Folders',
        component: () => import('@/views/folders.vue'),
      },
      {
        path: 'folder/:folderId',
        name: 'FolderProducts',
        component: FolderView,
        props: true,
      },
      {
        path: '/folders/:folderId/subfolders/:subfolderId/products',
        name: 'createProduct',
        component: CreateProduct,
      },
      {
        path: '/Stoku',
        name: 'stoku',
        component: Stoku,
      }
,

{
  path: '/raportimet',
  name: 'raportimet',
  component: raportimet,
},
{
  path: '/Create/stok',
  name: 'CreateStok',
  component: CreateStok,
}
,


      {
        path: '/klientet',
        name: 'klientet',
        component: Klientet,
      },      {
        path: '/edit/:id',
        name: 'editKlient',
        component: EditKlienti,
      },

      {
        path: '/create/klient',
        name: 'CreateKlient',
        component: CreateKlient,
      }
      ,

      {
        path: '/shitjet',
        name: 'shitjet',
        component: Shitjet,
      },
      {
        path: '/shitjet/edit/:id',
        name: 'editShitja',
        component: EditShitja,
      },


      {
        path: '/create-shitje',
        name: 'CreateShitje',
        component: CreateShitje,
      },

      
      {
        path: '/folder/:subfolderId/subfolder/:folderId',
        name: 'SubfolderProducts',
        component: FolderView,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
