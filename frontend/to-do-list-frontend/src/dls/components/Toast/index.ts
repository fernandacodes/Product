
import { Notify } from 'quasar';
import type { ToastProps } from './interface';

export const showToast = ({
    message,
    title = '',
    color = 'primary',
    position = 'top',
    timeout = 2000,
}: ToastProps) => {
    Notify.create({
        message,
        caption: title,
        color,
        position,
        timeout,
    });
};
