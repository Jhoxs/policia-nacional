import React, { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Head, Link, usePage } from '@inertiajs/react';
import { MenuFoldOutlined, MenuUnfoldOutlined, SmileOutlined, UserOutlined, CarOutlined, InboxOutlined,
    HomeOutlined, LockOutlined, LogoutOutlined, ApiOutlined, CaretDownOutlined, EnvironmentOutlined, TagsOutlined,
    SnippetsOutlined, RocketOutlined, AuditOutlined, IdcardOutlined, SwapOutlined
} from '@ant-design/icons';
import { Layout, Menu, Button, Col, theme, Row, Dropdown, Space, Typography, Avatar, Grid } from 'antd';
import CustomAvatar from '@/Components/CustomAvatar';
import FlashMessage from '@/Components/FlashMessage';


const { Header, Sider, Content, Footer } = Layout;

const { useBreakpoint } = Grid;


const items = [
    {
        key: 'profile',
        label: (
            <Link href={route('profile.edit')}>
                Mi Perfil
            </Link>
        ),
        icon: <UserOutlined />,
    },
    {
        key: 'logout',
        label: (
            <Link href={route('logout')} method='post' as='div'>
                Cerrar Sesión
            </Link>
        ),
        icon: <LogoutOutlined />,
    },
];

export default function Authenticated({ user, header, title, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
    const { auth } = usePage().props
    const [collapsed, setCollapsed] = useState(false);
    const userVehicle = auth.vehicle || []; 

    const idUserVehicle = userVehicle && userVehicle.length > 0 ? userVehicle[0].id : -1;

    const permissions = auth.permissions || [];
   
    const childDependece = [
        {
            key: 'province.index',
            label: (
                <Link href={route('province.index')}>
                    Provincias
                </Link>
            ),
        },
        {
            key: 'city.index',
            label: (
                <Link href={route('city.index')}>
                    Ciudades/Distritos
                </Link>
            ),
        },
        {
            key: 'parish.index',
            label: (
                <Link href={route('parish.index')}>
                    Parroquias
                </Link>
            ),
        },
        {
            key: 'circuit.index',
            label: (
                <Link href={route('circuit.index')}>
                    Circuitos
                </Link>
            ),
        },
        {
            key: 'subcircuit.index',
            label: (
                <Link href={route('subcircuit.index')}>
                    Subcircuitos
                </Link>
            ),
        },
    ];

    const childAssignments = [
        {
            key: 'subuser.index',
            label: (
                <Link href={route('subuser.index')}>
                    Usuarios Subcircuitos
                </Link>
            ),
        },
        {
            key: 'uservehicle.index',
            label: (
                <Link href={route('uservehicle.index')}>
                    Vehículos Usuarios 
                </Link>
            ),
        },
        {
            key: 'subvehicle.index',
            label: (
                <Link href={route('subvehicle.index')}>
                    Vehículos Subcircuitos
                </Link>
            ),
        },
    ];
    
    const  childRequest = [
        {
            key: 'requestmaintenance.index',
            label: (
                <Link href={route('requestmaintenance.index')}>
                    Solicitudes de Mantenimientos
                </Link>
            ),
        }
    ];

    const fChildDependece = childDependece.filter(item => permissions.includes(item.key));
    const fChildAssignments = childAssignments.filter(item => permissions.includes(item.key));
    const fChildRequest = childRequest.filter(item => permissions.includes(item.key));

    const menuItems = [
        {
            key: 'dashboard.index',
            icon: <HomeOutlined />,
            label: (
                <Link href={route('dashboard.index')}>
                    Página de Inicio
                </Link>
            )
        },
        {
            key: 'user.index',
            icon: <UserOutlined />,
            label: (
                <Link href={route('user.index')}>
                    Usuarios
                </Link>
            )
        },
        {
            key: 'vehicle.index',
            icon: <CarOutlined />,
            label: (
                <Link href={route('vehicle.index')}>
                    Vehículos
                </Link>
            ),
        },
        {
            key: 'profile-vehicle.show',
            icon: <IdcardOutlined />,
            label: (
                <Link href={route('profile-vehicle.show', idUserVehicle)}>
                    Perfil Vehículo
                </Link>
            ),
        },
        {
            key: 'contract.index',
            icon: <SnippetsOutlined />,
            label: (
                <Link href={route('contract.index')}>
                    Contratos
                </Link>
            ),
        },
        {
            key: 'spare.index',
            icon: <RocketOutlined />,
            label: (
                <Link href={route('spare.index')}>
                    Repuestos
                </Link>
            ),
        },
        {
            key: 'maintenance.index',
            icon: <ApiOutlined />,
            label: (
                <Link href={route('maintenance.index')}>
                    Mantenimientos
                </Link>
            ),
        },
        {
            key: 'morder.index',
            icon: <SwapOutlined />,
            label: (
                <Link href={route('morder.index')}>
                    Orden Movilización
                </Link>
            ),
        },
        {
            key: 'generalrequest.index',
            icon: <InboxOutlined />,
            label: (
                <>
                    Solicitudes
                </>
                
            ),
            children:fChildRequest
        },
        {
            key: 'dependence.index',
            icon: <EnvironmentOutlined />,
            label: (
                <>
                    Dependencias
                </>
                
            ),
            children:fChildDependece
        },
        {
            key: 'assignments.index',
            icon: <TagsOutlined />,
            label: (
                <>
                    Asignaciones
                </>
                
            ),
            children:fChildAssignments
        },
        {
            key: 'rol.index',
            icon: <LockOutlined />,
            label: (
                <Link href={route('rol.index')}>
                    Roles
                </Link>
            ),
        },
        {
            key: 'report.index',
            icon: <AuditOutlined />,
            label: (
                <Link href={route('report.index')}>
                    Informes
                </Link>
            ),
        },
        {
            key: 'suggestion.index',
            icon: <SmileOutlined />,
            label: (
                <Link href={route('suggestion.index')}>
                    Sugerencias
                </Link>
            ),
        },
    ];

    const filteredMenuItems = menuItems.filter(item => permissions.includes(item.key)|| (item.key === 'profile-vehicle.show' && idUserVehicle  !== -1) || (item.key === 'morder.index') );

    const {
        token: { colorBgContainer },
    } = theme.useToken();

    const siderStyle = {
        /*  backgroundColor: 'white', */
        backgroundColor: '#154986',
        overflow: 'auto',
        height: '100vh',
        position: 'fixed',
        left: 0,
        top: 0,
        bottom: 0,

    };

    const footerStyle = {
        textAlign: 'right',
        color: '#bfbfbf',
        backgroundColor: '#f5f5f5',
        height: '1.5rem'
    };

    const headerStyle = {
        padding: 0,
        background: colorBgContainer,
    }

    const contetStyle = {
        //margin: '12px 8px',
        overflow: 'initial',
        padding: 24,
        minHeight: '88vh',
        background: colorBgContainer,
        borderRadius: '0px'
    }


    return (
        <>
            <Layout>
                <Head title={title} />
                <Sider
                    trigger={null}
                    collapsible
                    breakpoint="sm"
                    collapsed={collapsed}
                    style={siderStyle}
                    onBreakpoint={(broken) => {
                        setCollapsed(broken);
                    }}
                    className='z-1'
                >
                    <div className="flex flex-col justify-center items-center shadow-xl bg-[#203956] mb-5 w-full rounded-b-[12px]">

                        <div className="mt-4 mb-2 w-13 items-center rounded-full px-3 py-3 bg-white">
                            <Link href="/">
                                <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                            </Link>

                        </div>
                        <div className="items-center justify-center text-white mb-1">
                            {!collapsed ? <div className="mb-2"><b>POLICIA NACIONAL</b></div> : null}
                        </div>
                    </div>
                    <Menu
                        theme="dark"
                        mode="vertical"
                        defaultSelectedKeys={[route().current()]}
                        style={{ backgroundColor: '#154986' }}
                        items={filteredMenuItems}
                    />
                </Sider>

                <Layout className="site-layout" style={!collapsed?{marginLeft: 200 }:{marginLeft: 80 }}>
                    <Header style={headerStyle} className='shadow-md z-1'>
                        <Row justify='space-between'>
                            <Col>
                                <Button
                                    type="text"
                                    icon={collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}
                                    onClick={() => setCollapsed(!collapsed)}
                                    style={{
                                        fontSize: '16px',
                                        width: 53,
                                        height: 64,
                                    }}
                                />

                            </Col>
                            <Col >
                                <Dropdown menu={{ items }} trigger={['click']}>
                                    <div>
                                        <Typography.Text className='auth-dropdown'>
                                            <Space size={12}>
                                                <Avatar size={42} icon={<UserOutlined />} />
                                                <div className='hidden sm:block'>
                                                    <div>
                                                        <Typography.Text strong>{auth.user.name} {auth.user.last_name} </Typography.Text>
                                                    </div>
                                                    <div>{auth.user.email}</div>
                                                </div>
                                                <CaretDownOutlined className='hidden sm:block' style={{ width: '2em' }} />
                                            </Space>
                                        </Typography.Text>
                                    </div>
                                </Dropdown>
                            </Col>
                        </Row>
                    </Header>

                    <Content
                        style={contetStyle}
                    >
                        <div className='fixed top-0 left-[40%] z-10 transition translate-y-4'>
                            <FlashMessage />
                        </div>

                        {children}
                    </Content>
                    {/* <Footer style={footerStyle}> Author José Hernández</Footer> */}
                </Layout>
            </Layout>
        </>
    );
}
