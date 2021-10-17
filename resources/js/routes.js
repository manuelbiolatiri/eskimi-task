import AllCampaigns from './components/AllCampaigns.vue';
import CreateCampaign from './components/CreateCampaign.vue';
import EditCampaign from './components/EditCampaign.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllCampaigns
    },
    {
        name: 'create',
        path: '/create',
        component: CreateCampaign
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditCampaign
    }
];