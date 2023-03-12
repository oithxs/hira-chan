import { routesContext, userContext } from "../../hooks/useContext";
import { Logout } from "../../feature/auth/components/Logout";
import { cutText } from "../../utils/format";

const HxSLogo = () => {
    return (
        <a href="https://oithxs.github.io/" className="vw-5">
            <img src="/img/hxs_logo.svg" alt="hxs sns logo" />
        </a>
    );
};

const Title = () => {
    const routes: { [key: string]: string } = routesContext();

    return (
        <a href={routes["dashboard"]} className="vw-10">
            <img src="/img/hira-chan.svg" alt="hira-chan logo" />
        </a>
    );
};

const AcctCtrDropDown = () => {
    const routes: { [key: string]: string } = routesContext();
    const user: { [key: string]: string } = userContext();

    return (
        <div className="dropdown mx-1">
            <a
                className="btn btn-secondary dropdown-toggle"
                href="#"
                role="button"
                id="dropdownMenuLink"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                {cutText(user["name"])}
            </a>
            <ul className="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li>
                    <p className="dropdown-header">アカウント管理</p>
                </li>
                <li>
                    <a className="dropdown-item" href={routes["myPage"]}>
                        マイページ
                    </a>
                </li>
                <li>
                    <a className="dropdown-item" href={routes["threadHistory"]}>
                        閲覧履歴
                    </a>
                </li>
                <li>
                    <a className="dropdown-item" href={routes["profileShow"]}>
                        プロフィール
                    </a>
                </li>
                <li>
                    <hr className="dropdown-divider" />
                </li>
                <li>
                    <Logout class="dropdown-item" />
                </li>
            </ul>
        </div>
    );
};

const AuthFalse = () => {
    const routes: { [key: string]: string } = routesContext();

    return (
        <div>
            <a href={routes["login"]} className="btn btn-outline-dark mx-1">
                ログイン
            </a>
            <a href={routes["register"]} className="btn btn-secondary mx-1">
                新規登録
            </a>
        </div>
    );
};

export const Header = () => {
    const user: { [key: string]: string } = userContext();
    const acctCtr = user["name"] !== "" ? AcctCtrDropDown() : AuthFalse();

    return (
        <header className="bg-aqua vh-12">
            <div className="flex-between mx-3">
                <div className="flex-center">
                    <HxSLogo />
                    <Title />
                </div>
                <div>{acctCtr}</div>
            </div>
        </header>
    );
};
