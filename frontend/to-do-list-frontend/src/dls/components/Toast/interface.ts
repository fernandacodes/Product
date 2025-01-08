export interface ToastProps {
    message: string;
    title?: string;
    color?: string;
    position?:
    | "top-left"
    | "top-right"
    | "bottom-left"
    | "bottom-right"
    | "top"
    | "bottom"
    | "left"
    | "right"
    | "center";
    timeout?: number;
}
