<template>
  <component
    is="a-modal"
    v-model:visible="visible"
    :fullscreen="true"
    :title="title"
    :mask-closable="false"
    :ok-loading="loading"
    @cancel="close"
    @before-ok="submit">
    <!-- 表单信息 start -->
    <a-form ref="formRef" :model="formData" :rules="rules" :auto-label-width="true">
      <a-form-item label="文章分类" field="category_id">
        <a-tree-select 
          v-model="formData.category_id"
          :data="categoryData"
          :field-names="{ key: 'id', title: 'category_name', icon: 'customIcon' }"
          placeholder="请选择文章分类"
          allow-clear
        />
      </a-form-item>
      <a-form-item label="文章标题" field="title">
        <a-input v-model="formData.title" placeholder="请输入文章标题" />
      </a-form-item>
      <a-form-item label="文章作者" field="author">
        <a-input v-model="formData.author" placeholder="请输入文章作者" />
      </a-form-item>
      <a-form-item label="文章图片" field="image">
        <sa-upload-image v-model="formData.image" :limit="3" :multiple="false" />
      </a-form-item>
      <a-form-item label="文章简介" field="describe">
        <a-textarea v-model="formData.describe" placeholder="请输入文章简介" />
      </a-form-item>
      <a-form-item label="文章内容" field="content">
        <ma-wangEditor v-model="formData.content" :height="400" />
      </a-form-item>
      <a-form-item label="浏览次数" field="views">
        <a-input-number v-model="formData.views" placeholder="请输入浏览次数" />
      </a-form-item>
      <a-form-item label="排序" field="sort">
        <a-input-number v-model="formData.sort" placeholder="请输入排序" />
      </a-form-item>
      <a-form-item label="状态" field="status">
        <sa-radio v-model="formData.status" dict="data_status" />
      </a-form-item>
      <a-form-item label="是否外链" field="is_link">
        <sa-radio v-model="formData.is_link" dict="yes_or_no" />
      </a-form-item>
      <a-form-item label="链接地址" field="link_url">
        <a-input v-model="formData.link_url" placeholder="请输入链接地址" />
      </a-form-item>
      <a-form-item label="是否热门" field="is_hot">
        <sa-radio v-model="formData.is_hot" dict="yes_or_no" />
      </a-form-item>
    </a-form>
    <!-- 表单信息 end -->
  </component>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Message, Modal } from '@arco-design/web-vue'
import api from '../../api/news/article'
import category from '../../api/news/category'

const emit = defineEmits(['success'])
// 引用定义
const visible = ref(false)
const loading = ref(false)
const formRef = ref()
const mode = ref('')
const categoryData = ref([])

let title = computed(() => {
  return '文章管理' + (mode == 'add' ? '-新增' : '-编辑')
})

// 表单信息
const formData = reactive({
  id: null,
  category_id: null,
  title: '',
  author: '',
  image: '',
  describe: '',
  content: '',
  views: null,
  sort: 100,
  status: 1,
  is_link: 2,
  link_url: '',
  is_hot: 2,
})

// 验证规则
const rules = {
  category_id: [{ required: true, message: '分类id必需填写' }],
  title: [{ required: true, message: '文章标题必需填写' }],
  describe: [{ required: true, message: '文章简介必需填写' }],
  content: [{ required: true, message: '文章内容必需填写' }],
}

// 打开弹框
const open = async (type = 'add') => {
  mode.value = type
  visible.value = true
  formRef.value.resetFields()
  await initPage()
}

// 初始化页面数据
const initPage = async () => {
  const resp = await category.getPageList()
  categoryData.value = resp.data
}

// 设置数据
const setFormData = async (data) => {
  for (const key in formData) {
    if (data[key] != null && data[key] != undefined) {
      formData[key] = data[key]
    }
  }
}

// 数据保存
const submit = async (done) => {
  const validate = await formRef.value?.validate()
  if (!validate) {
    loading.value = true
    let data = { ...formData }
    let result = {}
    if (mode.value === 'add') {
      // 添加数据
      data.id = undefined
      result = await api.save(data)
    } else {
      // 修改数据
      result = await api.update(data.id, data)
    }
    if (result.code === 200) {
      Message.success('操作成功')
      emit('success')
      done(true)
    }
    // 防止连续点击提交
    setTimeout(() => {
      loading.value = false
    }, 500)
  }
  done(false)
}

// 关闭弹窗
const close = () => (visible.value = false)

defineExpose({ open, setFormData })
</script>
