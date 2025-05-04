<template>
  <div class="ma-content-block">
    <sa-table ref="crudRef" :options="options" :columns="columns" :searchForm="searchForm">
      <!-- 搜索区 tableSearch -->
      <template #tableSearch>
        <a-col :sm="8" :xs="24">
          <a-form-item label="文章标题" field="title">
            <a-input v-model="searchForm.title" placeholder="请输入文章标题" allow-clear />
          </a-form-item>
        </a-col>
      </template>

      <!-- Table 自定义渲染 -->
    </sa-table>

    <!-- 编辑表单 -->
    <edit-form ref="editRef" @success="refresh" />

  </div>
</template>

<script setup>
import { onMounted, ref, reactive } from 'vue'
import { Message } from '@arco-design/web-vue'
import EditForm from './edit.vue'
import api from '../../api/news/article'

// 引用定义
const crudRef = ref()
const editRef = ref()
const viewRef = ref()

// 搜索表单
const searchForm = ref({
  title: '',
})

// SaTable 基础配置
const options = reactive({
  api: api.getPageList,
  rowSelection: { showCheckedAll: true },
  add: {
    show: true,
    auth: ['/app/saicms/news/Article/save'],
    func: async () => {
      editRef.value?.open()
    },
  },
  edit: {
    show: true,
    auth: ['/app/saicms/news/Article/update'],
    func: async (record) => {
      editRef.value?.open('edit')
      editRef.value?.setFormData(record)
    },
  },
  delete: {
    show: true,
    auth: ['/app/saicms/news/Article/destroy'],
    func: async (params) => {
      const resp = await api.destroy(params)
      if (resp.code === 200) {
        Message.success(`删除成功！`)
        crudRef.value?.refresh()
      }
    },
  },
})

// SaTable 列配置
const columns = reactive([
  { title: '文章标题', dataIndex: 'title', width: 180 },
  { title: '文章作者', dataIndex: 'author', width: 180 },
  { title: '文章图片', dataIndex: 'image', type: 'image', width: 120 },
  { title: '文章简介', dataIndex: 'describe', width: 180 },
  { title: '浏览次数', dataIndex: 'views', width: 180 },
  { title: '排序', dataIndex: 'sort', width: 180 },
  { title: '状态', dataIndex: 'status', type: 'dict', dict: 'data_status', width: 120 },
  { title: '是否外链', dataIndex: 'is_link', type: 'dict', dict: 'yes_or_no', width: 120 },
  { title: '链接地址', dataIndex: 'link_url', width: 180 },
  { title: '是否热门', dataIndex: 'is_hot', type: 'dict', dict: 'yes_or_no', width: 120 },
])

// 页面数据初始化
const initPage = async () => {}

// SaTable 数据请求
const refresh = async () => {
  crudRef.value?.refresh()
}

// 页面加载完成执行
onMounted(async () => {
  initPage()
  refresh()
})
</script>
