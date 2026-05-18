import { Link } from '@inertiajs/react';
import AppLogoIcon from '@/components/app-logo-icon';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div className="flex min-h-svh flex-col items-center justify-center bg-[#F5F5DC] p-4 md:p-8">
            <div className="w-full max-w-sm">
                <div className="rounded-xl bg-white p-8 shadow-md">
                    <div className="flex flex-col items-center gap-4">
                        <Link
                            href={home()}
                            className="flex flex-col items-center gap-2 font-medium"
                        >
                            <div className="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                                <AppLogoIcon className="size-9 fill-[#5C4033]" />
                            </div>
                            <span className="sr-only">{title}</span>
                        </Link>

                        <div className="space-y-2 text-center">
                            <h1 className="text-xl font-medium text-[#5C4033]">{title}</h1>
                            <p className="text-center text-sm text-slate-600">
                                {description}
                            </p>
                        </div>
                    </div>
                    <div className="mt-6">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
}
