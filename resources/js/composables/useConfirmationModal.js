import { ref } from 'vue';

const isVisible = ref(false);
const message = ref('');
let onConfirmCallback = null;

export const useConfirmationModal = () => {
  const openModal = (msg, onConfirm) => {
    message.value = msg;
    onConfirmCallback = onConfirm;
    isVisible.value = true;
  };

  const closeModal = () => {
    isVisible.value = false;
  };

  const confirmAction = () => {
    if (onConfirmCallback) onConfirmCallback();
    closeModal();
  };

  return {
    isVisible,
    message,
    openModal,
    closeModal,
    confirmAction,
  };
};
