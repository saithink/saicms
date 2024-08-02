<template>
  <component
    is="a-modal"
    v-model:visible="visible"
    :width="600"
    :title="title"
    :mask-closable="false"
    :ok-loading="loading"
    @cancel="close"
    @before-ok="submit">
    <!-- 表单信息 start -->
    <a-form ref="formRef" :model="formData" :rules="rules" :auto-label-width="true">
      <a-form-item label="类型" field="banner_type">
        <sa-select v-model="formData.banner_type" dict="backend_notice_type" placeholder="请选择类型" allow-clear />
      </a-form-item>
      <a-form-item label="图片地址" field="image">
        <sa-upload-image v-model="formData.image" :limit="3" :multiple="false" />
      </a-form-item>
      <a-form-item label="是否链接" field="is_href">
        <sa-radio v-model="formData.is_href" dict="yes_or_no" />
      </a-form-item>
      <a-form-item label="链接地址" field="url">
        <a-input v-model="formData.url" placeholder="请输入链接地址" />
      </a-form-item>
      <a-form-item label="标题" field="title">
        <a-input v-model="formData.title" placeholder="请输入标题" />
      </a-form-item>
      <a-form-item label="状态" field="status">
        <sa-radio v-model="formData.status" dict="data_status" />
      </a-form-item>
      <a-form-item label="排序" field="sort">
        <a-input-number v-model="formData.sort" placeholder="请输入排序" />
      </a-form-item>
    </a-form>
    <!-- 表单信息 end -->
  </component>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Message, Modal } from '@arco-design/web-vue'
import api from '../../api/news/banner'

const emit = defineEmits(['success'])
// 引用定义
const visible = ref(false)
const loading = ref(false)
const formRef = ref()
const mode = ref('')

let title = computed(() => {
  return '文章轮播' + (mode == 'add' ? '-新增' : '-编辑')
})

// 表单信息
const formData = reactive({
  id: null,
  banner_type: 1,
  image: '',
  is_href: 1,
  url: '',
  title: '',
  status: 1,
  sort: null,
})

// 验证规则
const rules = {
  banner_type: [{ required: true, message: '类型必需填写' }],
  title: [{ required: true, message: '标题必需填写' }],
}

// 打开弹框
const open = async (type = 'add') => {
  mode.value = type
  visible.value = true
  formRef.value.resetFields()
  await initPage()
}

// 初始化页面数据
const initPage = async () => {}

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
