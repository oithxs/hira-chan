import { useContext } from "react";
import { RoutesContext, UserContext } from "../providers/app";

export const routesContext = (): { [key: string]: string } =>
    useContext(RoutesContext);
    
export const userContext = (): { [key: string]: string } =>
    useContext(UserContext);
