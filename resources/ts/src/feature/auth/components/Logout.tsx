import { routesContext } from "../../../hooks/useContext";
import { logout } from "../api/logout";

/** ログアウト用のリンクを表示する関数の引数の型 */
type logoutProps = {
    class?: string;
};

/**
 * ログアウト用のリンクを表示する
 *
 * @param {logoutProps} props - cssのクラス
 * @returns
 */
export const Logout = (props: logoutProps) => {
    const routes: { [key: string]: string } = routesContext();

    return (
        <a
            href="#"
            className={props["class"]}
            onClick={() => logout(routes["logout"])}
        >
            ログアウト
        </a>
    );
};
