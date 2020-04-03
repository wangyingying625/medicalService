<!-- App.vue -->
<template>
    <div id="app">
        <el-container>
            <el-header>
                <el-menu
                        class="el-menu-demo"
                        mode="horizontal"
                        background-color="#545c64"
                        text-color="#fff"
                        active-text-color="#ffd04b">
                    <el-menu-item index="1"><router-link to="/">首页</router-link></el-menu-item>






                    <el-submenu index="2">
                        <template slot="title">病历记录</template>
                        <router-link to="/recordPicture"  style="text-decoration: none"><el-menu-item index="2-1">图片记录</el-menu-item></router-link>
                        <router-link to="/record" style="text-decoration: none"><el-menu-item index="2-2" >病历图表</el-menu-item></router-link>
                    </el-submenu>
                    <el-submenu index="3">
                        <template slot="title">上传病历</template>
                        <router-link to="/oneClick"  style="text-decoration: none"><el-menu-item index="3-1">一键上传</el-menu-item></router-link>
                        <router-link to="/Template" style="text-decoration: none"><el-menu-item index="3-2" >模板上传</el-menu-item></router-link>
                    </el-submenu>
                    <el-menu-item index="4"><router-link to="/family">我的家庭</router-link></el-menu-item>
                    <el-menu-item index="5"><router-link to="/geRen">个人中心</router-link></el-menu-item>
                </el-menu>
                <div class="line"></div>
            </el-header>
            <el-main>
                <router-view></router-view>
            </el-main>
            <el-footer>
            </el-footer>
        </el-container>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name:'app'
    }
</script>

<style scoped>
</style>


