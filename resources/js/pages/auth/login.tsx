import { Head, useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/auth-layout';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

const container = {
    hidden: {},
    show: {
        transition: { staggerChildren: 0.1 },
    },
};

const item = {
    hidden: { opacity: 0, y: 12 },
    show: { opacity: 1, y: 0, transition: { duration: 0.6, ease: 'easeOut' as const } },
};

type Props = {
    status?: string;
    canResetPassword: boolean;
};

export default function Login({
    status,
    canResetPassword,
}: Props) {
    const { data, setData, post, processing, errors } = useForm({
        nama: '',
        password: '',
        remember: false,
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post(store.url());
    }

    return (
        <AuthLayout
            title="Log in to your account"
            description="Enter your username and password below to log in"
        >
            <Head title="Log in">
    <meta name="robots" content="noindex, nofollow" />
</Head>

            <motion.div
                variants={container}
                initial="hidden"
                whileInView="show"
                viewport={{ once: true, amount: 0.2 }}
            >
                <motion.div variants={item}>
                    <form
                        onSubmit={handleSubmit}
                        method="POST"
                        action={store.url()}
                        noValidate
                        className="flex flex-col gap-6"
                    >
                        <div className="grid gap-6">
                            <div className="grid gap-2">
                                <Label htmlFor="nama">Username</Label>
                                <Input
                                    id="nama"
                                    name="nama"
                                    type="text"
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="username"
                                    placeholder="Username"
                                    value={data.nama}
                                    onChange={e => setData('nama', e.target.value)}
                                />
                                <InputError message={errors.nama} />
                            </div>

                            <div className="grid gap-2">
                                <div className="flex items-center">
                                    <Label htmlFor="password">Password</Label>
                                    {canResetPassword && (
                                        <TextLink
                                            href={request()}
                                            className="ml-auto text-sm"
                                            tabIndex={5}
                                        >
                                            Forgot password?
                                        </TextLink>
                                    )}
                                </div>
                                <Input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    tabIndex={2}
                                    autoComplete="current-password"
                                    placeholder="Password"
                                    value={data.password}
                                    onChange={e => setData('password', e.target.value)}
                                />
                                <InputError message={errors.password} />
                            </div>

                            <div className="flex items-center space-x-3">
                                <Checkbox
                                    id="remember"
                                    tabIndex={3}
                                    checked={data.remember}
                                    onCheckedChange={checked => setData('remember', checked === true)}
                                />
                                <Label htmlFor="remember">Remember me</Label>
                            </div>

                            <Button
                                type="submit"
                                className="mt-4 w-full bg-[#5C4033] text-white hover:bg-[#4a342a]"
                                tabIndex={4}
                                disabled={processing}
                                data-test="login-button"
                            >
                                {processing && <Spinner />}
                                Log in
                            </Button>
                        </div>
                    </form>
                </motion.div>

                {status && (
                    <motion.div variants={item} className="mb-4 text-center text-sm font-medium text-green-600">
                        {status}
                    </motion.div>
                )}
            </motion.div>
        </AuthLayout>
    );
}
