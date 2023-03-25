import {
    Box,
    Typography,
    Link,
    Grid,
    Avatar,
} from "@mui/material";

function HiraChanLinks() {
    return (
        <>
            <Grid container spacing={3}>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        トップ
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        ログイン
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        新規登録
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        ヘルプ
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        お知らせ
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        利用規約
                    </Link>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={3} xl={2}>
                    <Link
                        href=""
                        underline="hover"
                        color="inherit"
                        sx={{ mx: 2 }}
                    >
                        問い合わせ
                    </Link>
                </Grid>
            </Grid>
        </>
    );
}

function CopyRight() {
    return (
        <>
            <Box
                sx={{
                    bgcolor: "primary.main",
                    color: "primary.contrastText",
                    p: 5,
                }}
                display="flex"
                justifyContent="center"
            >
                <Typography variant="h6">
                    © 2023~{" "}
                    <Link
                        href="https://oithxs.github.io/"
                        underline="hover"
                        color="inherit"
                    >
                        HxSコンピュータ部
                    </Link>
                    . All rights reserved.
                </Typography>
            </Box>
        </>
    );
}

export const Footer = () => {
    return (
        <>
            <Box
                sx={{
                    bgcolor: "primary.main",
                    color: "primary.contrastText",
                    p: 5,
                }}
                className="footer"
                display="flex"
                justifyContent="center"
            >
                <Grid container spacing={3} justifyContent="center">
                    <Grid item xs={12} sm={4}>
                        <Grid
                            container
                            spacing={3}
                            className="hira-chan-icons"
                            display="flex"
                            justifyContent="center"
                            sx={{ mr: 5 }}
                        >
                            <Grid item xs={12} xl={4} justifyContent="center">
                                <Avatar
                                    alt="Hira-chan-icon"
                                    src="/c/Users/game work/PgCodeInside/local/react-footer-sandbox/public/favicon.ico"
                                    sx={{
                                        width: 128,
                                        height: 128,
                                        mr: 2,
                                    }}
                                />
                            </Grid>
                            <Grid item xs={12} xl={8}>
                                <Typography variant="h3">Hira Chan</Typography>
                                <Typography variant="h6">
                                    枚方で爆誕した掲示板
                                </Typography>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12} sm={8}>
                        <Box className="hira-chan-links">
                            <HiraChanLinks />
                        </Box>
                    </Grid>
                </Grid>
            </Box>
            <CopyRight />
        </>
    );
};
