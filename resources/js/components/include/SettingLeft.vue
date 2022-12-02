<template>
    <div class="setting-left">
        <nav class="nav flex-column">
            <router-link v-for="item in navigation" :key="item.id" :to="item.url" :class="{'active-tab' : $route.name == item.tab}" class="nav-link color-gray">
                {{item.name}}
            </router-link>
        </nav>
    </div>
</template>
<script>
export default {
    name: 'SettingLeft',
    props: {
        navigation: Array
    }
}
</script>
<style scoped>
    .setting-left{
        background: #FFFFFF;
        box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        height: 100vh;
        max-height: calc(100vh - 195px);
    }

    .setting-left .nav-link{
        border-bottom: 1px solid #EFEEF3;
        font-size: 16px;
        line-height: 16px;
        font-weight: 500;
        padding: 15px 10px;
    }
    .setting-left .nav-link:first-child{
        border-radius: 10px 10px 0px 0px;
    }
    .setting-left .nav-link.active-tab{
        background: #0AB39C;
        color: #fff;
    }
    @media screen and (max-width:1180px) {
        .setting-left{
            max-height: calc(100vh - 158px);
        }
    }
    @media screen and (max-width:820px) {
        .setting-left{
            max-height: calc(100vh - 190px);
        }
    }
</style>
