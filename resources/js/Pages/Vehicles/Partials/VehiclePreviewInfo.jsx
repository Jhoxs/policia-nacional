
import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal, Avatar, Card } from 'antd';
import { FileSearchOutlined, BugOutlined, VerifiedOutlined, IdcardOutlined, PicCenterOutlined, AlertOutlined, SlidersOutlined, VerticalAlignTopOutlined, DashboardOutlined, TeamOutlined, CarOutlined } from '@ant-design/icons';
const { Title, Text } = Typography;

export default function VehiclePreviewInfo({ modelPreview, customTitle }) {

    const gridStyle = {
        width: '100%',
        padding: '10px'

    };

    return (
        <>
            { !customTitle && (
                <div className="flex justify-center">
                    <Title level={3}>
                        Información General
                    </Title>
                </div>
            )}
            { customTitle && (
                
                <Title level={customTitle.level || 3}>
                    { customTitle.title || 'Información'}
                </Title>
            
            )}
            <div className='mt-2'>
                <Card style={customTitle?.style}>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <IdcardOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.plate} </Text>
                                </div>
                                <div>Placa</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <BugOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.chassis} </Text>
                                </div>
                                <div>Chasis</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <VerifiedOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.brand} </Text>
                                </div>
                                <div>Marca</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <FileSearchOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.model} </Text>
                                </div>
                                <div>Modelo</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <PicCenterOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.motor} </Text>
                                </div>
                                <div>Motor</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <DashboardOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.mileage} </Text>
                                </div>
                                <div>Kilometraje</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <AlertOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.next_mileage} </Text>
                                </div>
                                <div>Próximo Kilometraje</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <SlidersOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.cylinder_capacity} </Text>
                                </div>
                                <div>Capacidad de Cilindraje</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <VerticalAlignTopOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.loading_capacity} </Text>
                                </div>
                                <div>Capacidad de Carga</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <TeamOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.passenger_capacity} </Text>
                                </div>
                                <div>Número de Pasajeros</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle} hoverable={!customTitle}>
                        <Space size={20}>
                            <CarOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.vehicle_type} </Text>
                                </div>
                                <div>Tipo de Vehículo</div>
                            </div>
                        </Space>
                    </Card.Grid>
                </Card>
            </div>

        </>
    );
}