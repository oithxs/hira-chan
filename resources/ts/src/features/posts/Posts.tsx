import { Typography, Box, Link, Grid, Button } from "@mui/material";
import Image from "mui-image";
// APIで取得すようにするので下記のJSONは削除するように
const posts_data = {
    data: [
        {
            messageId: 1,
            message: "HELLO",
            createdAt: "2023-03-24 01:08:37",
            likesCount: 1,
            user: { name: "Admin" },
            threadImagePath: null,
            onLike: false,
        },
        {
            messageId: 2,
            message: "WORLD",
            createdAt: "2023-03-24 02:18:10",
            likesCount: 0,
            user: { name: "Admin" },
            threadImagePath: null,
            onLike: false,
        },
        {
            messageId: 3,
            message: "IMG",
            createdAt: "2023-03-24 02:37:51",
            likesCount: 0,
            user: { name: "Admin" },
            threadImagePath: {
                imgPath: "https://picsum.photos/id/674/2000",
            },
            onLike: false,
        },
    ],
};

function getAllPosts() {
    return posts_data.data.reverse().map((post) => {
        // もし、画像パスがある場合、画像を返却する
        function printImage() {
            if (post.threadImagePath != null) {
                return (
                    <Image
                        src={post.threadImagePath.imgPath}
                        fit="contain"
                        style={{ maxWidth: "800px", maxHeight: "600px" }}
                        showLoading={true}
                    />
                );
            }
        }
        return (
            <>
                <Grid container sx={{ mt: 2 }}>
                    <Grid item sx={{ mr: 1, mt: "auto" }}>
                        <Typography>{post.messageId} :</Typography>
                    </Grid>
                    <Grid item sx={{ mr: 1, mt: "auto" }}>
                        <Typography variant="h6">{post.user.name}</Typography>
                    </Grid>
                    <Grid item sx={{ mr: 1, mt: "auto" }}>
                        <Typography>{post.createdAt}</Typography>
                    </Grid>
                </Grid>
                <Box>
                    <Box sx={{ p: 2 }}>
                        <Typography>{post.message}</Typography>
                        {printImage()}
                    </Box>
                    <Grid container>
                        <Grid item>
                            <Button variant="outlined">いいね</Button>
                        </Grid>
                        <Grid item sx={{ m: "auto", ml: 2 }}>
                            <Typography>{post.likesCount}</Typography>
                        </Grid>
                    </Grid>
                </Box>

                <hr />
            </>
        );
    });
}

export const Posts = () => {
    return (
        <>
            <Box sx={{ p: 3 }} borderRadius={2} bgcolor="#f0f0f0">
                <Grid container>
                    <Grid item sx={{ mt: "auto" }}>
                        <Link href="/dashboard" underline="hover">
                            ＞戻る
                        </Link>
                    </Grid>
                    <Grid item sx={{ ml: 3 }}>
                        {/* TODO スレッド名を取得して書き込めるように */}
                        <Typography variant="h5">
                            ここにはスレッド名を書きます
                        </Typography>
                    </Grid>
                </Grid>

                <Box sx={{ mt: 2 }}>{getAllPosts()}</Box>
            </Box>
        </>
    );
};
