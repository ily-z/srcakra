// Components
import { Form, Head } from '@inertiajs/react';
import { motion } from 'framer-motion';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/auth-layout';
import { logout } from '@/routes';
import { send } from '@/routes/verification';

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

export default function VerifyEmail({ status }: { status?: string }) {
    return (
        <AuthLayout
            title="Verify email"
            description="Please verify your email address by clicking on the link we just emailed to you."
        >
            <Head title="Email verification" />

            <motion.div
                variants={container}
                initial="hidden"
                whileInView="show"
                viewport={{ once: true, amount: 0.2 }}
            >
                {status === 'verification-link-sent' && (
                    <motion.div variants={item} className="mb-4 text-center text-sm font-medium text-green-600">
                        A new verification link has been sent to the email address
                        you provided during registration.
                    </motion.div>
                )}

                <motion.div variants={item}>
                    <Form {...send.form()} className="space-y-6 text-center">
                        {({ processing }) => (
                            <>
                                <Button disabled={processing} variant="secondary">
                                    {processing && <Spinner />}
                                    Resend verification email
                                </Button>

                                <TextLink
                                    href={logout()}
                                    className="mx-auto block text-sm"
                                >
                                    Log out
                                </TextLink>
                            </>
                        )}
                    </Form>
                </motion.div>
            </motion.div>
        </AuthLayout>
    );
}
