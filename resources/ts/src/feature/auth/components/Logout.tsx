import { routesContext } from "../../../hooks/useContext";
import { logout } from "../api/logout";

type logoutProps = {
    class?: string;
};

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
