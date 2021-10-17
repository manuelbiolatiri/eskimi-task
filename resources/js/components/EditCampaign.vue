<template>
    <div>
        <h3 class="text-center">Edit Campaign</h3>
        <div class="row">
            <div class="col-md-6">
                       <input type="file" id='files' name="image" style="position: absolute; right:-10000px"
                                    accept="image/*" @change="uploadCampaignImage()">
                <form @submit.prevent="updateCampaign">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="campaign.name">
                    </div>
                     <div class="form-group">
                        <label>Start Date</label>
                        <input type="datetime" class="form-control" v-model="campaign.from" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="datetime" class="form-control" v-model="campaign.to" required>
                    </div>
                     <div class="form-group">
                        <label>Daily Budget</label>
                        <input type="number" class="form-control" v-model="campaign.daily_budget" required>
                    </div>
                     <div class="form-group">
                        <label>Total Budget</label>
                        <input type="number" class="form-control" v-model="campaign.total_budget" required>
                    </div>
                    <reusable-button :config="{'class': 'btn-primary','text':'Update','type':'submit'}"></reusable-button>
                </form>
            </div>
            <div class="col-md-6">
             <button class="btn btn-primary mb-4" @click="selectFile()">
                <i class="fas fa-camera"></i>
                Upload Images
            </button>
            <div class="row"   id="images-wrapper">
                <div class="col-md-6 image-wrappers" v-for="image in campaign.images" :key="image.id">
                    <p class="delete-btn" title="Remove Image" @click="deleteImage(image.id)">X</p>
                    <img :src="'http://localhost:8000/storage/campaign-images/'+image.url" alt="image" style="width:100%; height:200px; object-fit:contain">
                </div>
            </div>
            </div>
        
        </div>
    </div>
</template>

<style scoped>
    .delete-btn{
        z-index: 10;
        position: absolute;
        right: 20;
        top: 20;
        display: none;
        padding: 5px;
        font-size: 18px;
        color: red;
        cursor: pointer;
        font-weight: bold;
    }

    .image-wrappers{
        position: relative;
    }

    .image-wrappers:hover .delete-btn{
        display: inline-block;
    }
</style>
 
<script>
    import ReusableButton from './Button.vue';
    export default {
        data() {
            return {
                campaign: {},
                images:[],
            }
        },
        components:{
            ReusableButton
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/campaigns/${this.$route.params.id}`)
                .then((res) => {
                    this.campaign = res.data;
                    this.images = res.data.images;
                });
        },
        methods: {
            updateCampaign() {
                this.axios
                    .patch(`http://localhost:8000/api/campaigns/${this.$route.params.id}`, this.campaign)
                    .then((res) => {
                        this.$router.push({ name: 'home' });
                    });
            },
            uploadCampaignImage(){
                var form_data = new FormData();
                form_data.append('image', document.getElementById('files').files[0]);
                form_data.append('campaign_id', this.campaign.id);
                this.axios.post(`http://localhost:8000/api/images`,form_data)
                .then((res) => {
                    console.log(res);
                    if(res.data.status){
                        this.images.push(res.data.image);
                    }
                });
            },
            selectFile(){
                $("#files").click();
            },
            deleteImage(id) { 
                this.axios
                    .delete(`http://localhost:8000/api/images/${id}`)
                    .then(response => {
                        let i = this.images.map(data => data.id).indexOf(id);
                        this.images.splice(i, 1)
                    });
            }
        }
    }
</script>