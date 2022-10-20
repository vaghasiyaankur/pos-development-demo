<template>
  <div>
    <div role="alert" class="Vue-Toastification__toast-body d-flex align-items-center">
        <div class="Vue-Toastification__image me-3">
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" v-if="type == 'success'">
                <path d="M44 29C44 37.2843 37.2843 44 29 44L15 44C6.71573 44 3.22759e-06 37.2843 2.50336e-06 29L1.27944e-06 15C5.55202e-07 6.71573 6.71573 -5.55203e-07 15 -1.27944e-06L29 -2.50336e-06C37.2843 -3.22759e-06 44 6.71572 44 15L44 29Z" fill="white" fill-opacity="0.62"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M28.8811 12.7355C27.5198 14.0081 26.2587 15.3843 24.1215 17.9292C22.3082 20.0885 21.3316 21.4792 19.401 24.6515L18.7184 25.7731L17.9454 24.9865C16.6922 23.7115 15.634 22.8475 14.6308 22.2803L14.2657 22.0738L12.1328 22.0855L10 22.0971L10.2998 22.2941C11.886 23.3367 13.9639 25.3616 15.4736 27.3359C16.6419 28.8638 17.5907 30.4383 18.4117 32.2117L18.7768 33L19.5444 31.4441C20.7266 29.0479 21.7274 27.2486 23.1497 24.9628C25.7897 20.7198 29.0488 16.3759 32.2621 12.8172L33 12L31.3323 12.0015L29.6646 12.003L28.8811 12.7355Z" fill="#00BCA2"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none" v-else>
                <path d="M44 29C44 37.2843 37.2843 44 29 44L15 44C6.71573 44 3.22759e-06 37.2843 2.50336e-06 29L1.27944e-06 15C5.55202e-07 6.71573 6.71573 -5.55203e-07 15 -1.27944e-06L29 -2.50336e-06C37.2843 -3.22759e-06 44 6.71572 44 15L44 29Z" fill="white" fill-opacity="0.62"/>
                <path d="M26.893 14.3067L14.3072 26.8925C13.9167 27.283 13.9167 27.9162 14.3072 28.3067L15.693 29.6925C16.0835 30.083 16.7167 30.083 17.1072 29.6925L29.693 17.1067C30.0835 16.7162 30.0835 16.083 29.693 15.6925L28.3072 14.3067C27.9167 13.9162 27.2835 13.9162 26.893 14.3067Z" fill="#D34E4E"/>
                <path d="M29.6928 26.8925L17.107 14.3067C16.7165 13.9162 16.0833 13.9162 15.6928 14.3067L14.307 15.6925C13.9165 16.083 13.9165 16.7162 14.307 17.1067L26.8928 29.6925C27.2833 30.083 27.9165 30.083 28.307 29.6925L29.6928 28.3067C30.0833 27.9162 30.0833 27.283 29.6928 26.8925Z" fill="#D34E4E"/>
                </svg>
        </div>
        <div class="Vue-Toastification__message me-2">
            <p class="mb-0 text-capitalize">{{ type }}</p>
            <p class="mb-0">{{message}}</p>
        </div>
    </div>
  </div>
</template>
<script>
export default {
    name: 'Notification',
    props: ["message","type"],
};
</script>
<style>
.Vue-Toastification__icon{
    display:none;
}
.Vue-Toastification__progress-bar{
    height:0px !important;
    animation-play-state: running !important;
}
.Vue-Toastification__container{
    z-index: 11112;
}
.Vue-Toastification__toast{
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    padding: 10px 24px !important;
}
.Vue-Toastification__toast--success{
    background: linear-gradient(89.83deg, #ADF3E9 1.03%, #D5FCF9 99.85%);
    color:#0AB39C !important;
    border-right: 3px solid #0ab39c;
}
.Vue-Toastification__toast--success .Vue-Toastification__close-button{
    color:#0AB39C !important;
}
.Vue-Toastification__toast--error{
    background: linear-gradient(92.22deg, #FFBCBC -0.91%, #FFEDED 97.41%);
    color:#D34E4E !important;
    border-right: 3px solid #D34E4E;
}
.Vue-Toastification__toast--error .Vue-Toastification__close-button{
    color:#D34E4E !important;
}
</style>
