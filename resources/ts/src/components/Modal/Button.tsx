import React, { ReactNode } from "react";

/** モーダルを表示させるためのボタンを表示するメソッドの引数 */
type ButtonProps = {
    modalTarget: string;
    className?: string;
    children: ReactNode;
};

/**
 * モーダルを表示させるためのボタンを表示する
 *
 * @param {string} modalTarget - モーダルのターゲットID
 * @param {string} className - 省略可能．追加するclass
 * @param {ReactNode} children - ボタンのデザイン
 * @returns {JSX.Element}
 */
export const Button = ({ modalTarget, className, children }: ButtonProps) => (
    <button
        type="button"
        className={"btn " + className}
        data-bs-toggle="modal"
        data-bs-target={"#" + modalTarget}
    >
        {children}
    </button>
);
