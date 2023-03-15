import { ReactNode } from "react";

/** モーダルを表示する関数の引数 */
type modalProps = {
    id: string;
    children: ReactNode;
};

/**
 * モーダルを表示する
 *
 * @param {string} id - モーダルのID
 * @param {ReactNode} children - モーダルの要素
 * @returns {JSX.Element}
 */
export const Modal = ({ id, children }: modalProps) => (
    <div
        className="modal fade"
        id={id}
        aria-labelledby={id + "Label"}
        aria-hidden="true"
    >
        <div className="modal-dialog modal-dialog-centered">
            <div className="modal-content">{children}</div>
        </div>
    </div>
);
