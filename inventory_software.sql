/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 110102
 Source Host           : localhost:3306
 Source Schema         : inventory_software

 Target Server Type    : MariaDB
 Target Server Version : 110102
 File Encoding         : 65001

 Date: 18/03/2025 20:24:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for adjustments
-- ----------------------------
DROP TABLE IF EXISTS `adjustments`;
CREATE TABLE `adjustments`  (
  `adjustmentId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reffNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `adjustmentDate` datetime NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `locationId` int(11) UNSIGNED NOT NULL,
  `locationName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`adjustmentId`) USING BTREE,
  INDEX `adjustments_locationId_foreign`(`locationId`) USING BTREE,
  INDEX `IDXadjustmentId`(`adjustmentId`) USING BTREE,
  CONSTRAINT `adjustments_locationId_foreign` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of adjustments
-- ----------------------------

-- ----------------------------
-- Table structure for adjustments_details
-- ----------------------------
DROP TABLE IF EXISTS `adjustments_details`;
CREATE TABLE `adjustments_details`  (
  `adjustmentDetailId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `adjustmentId` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `AvailableQuantity` int(11) NOT NULL,
  `NewQuantity` int(11) NOT NULL,
  `AdjustedQuantity` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`adjustmentDetailId`) USING BTREE,
  INDEX `adjustments_details_productId_foreign`(`productId`) USING BTREE,
  INDEX `IDXadjustmentDetailId`(`adjustmentDetailId`) USING BTREE,
  CONSTRAINT `adjustments_details_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of adjustments_details
-- ----------------------------

-- ----------------------------
-- Table structure for approvals
-- ----------------------------
DROP TABLE IF EXISTS `approvals`;
CREATE TABLE `approvals`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `optionId` int(11) UNSIGNED NOT NULL,
  `optionName` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `userId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(3) NOT NULL,
  `sort` int(3) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of approvals
-- ----------------------------

-- ----------------------------
-- Table structure for auto_number
-- ----------------------------
DROP TABLE IF EXISTS `auto_number`;
CREATE TABLE `auto_number`  (
  `autoId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `configName` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `prefix` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `number` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`autoId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100006 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auto_number
-- ----------------------------
INSERT INTO `auto_number` VALUES (100001, 'SALES_ORDER_NUMBER', 'SO-', '100000');
INSERT INTO `auto_number` VALUES (100002, 'TRANSFER_LOCATION', 'LT-', '100000');
INSERT INTO `auto_number` VALUES (100003, 'PACKING_SLIP', 'PKG-', '100000');
INSERT INTO `auto_number` VALUES (100004, 'DELIVERY_ORDER', 'DO-', '100000');
INSERT INTO `auto_number` VALUES (100005, 'ADJUSTMENT', 'AJ-', '100000');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `customerId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerDisplay` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerEmail` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerPhone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerMobile` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerTypeId` int(11) NOT NULL,
  `customerCurrency` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `website` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `remark` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(11) UNSIGNED NOT NULL,
  `paymentTermId` int(11) UNSIGNED NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`customerId`) USING BTREE,
  INDEX `customers_statusId_foreign`(`statusId`) USING BTREE,
  INDEX `customers_paymentTermId_foreign`(`paymentTermId`) USING BTREE,
  CONSTRAINT `customers_paymentTermId_foreign` FOREIGN KEY (`paymentTermId`) REFERENCES `payment_terms` (`paymentTermId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customers_statusId_foreign` FOREIGN KEY (`statusId`) REFERENCES `customers_status` (`customerStatusId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------

-- ----------------------------
-- Table structure for customers_address
-- ----------------------------
DROP TABLE IF EXISTS `customers_address`;
CREATE TABLE `customers_address`  (
  `customerAddressId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerId` int(11) UNSIGNED NOT NULL,
  `customerAddressTypeId` int(11) NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `zipCode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`customerAddressId`) USING BTREE,
  INDEX `customers_address_customerId_foreign`(`customerId`) USING BTREE,
  CONSTRAINT `customers_address_customerId_foreign` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers_address
-- ----------------------------

-- ----------------------------
-- Table structure for customers_status
-- ----------------------------
DROP TABLE IF EXISTS `customers_status`;
CREATE TABLE `customers_status`  (
  `customerStatusId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customerStatusName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `orderBy` int(2) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`customerStatusId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers_status
-- ----------------------------
INSERT INTO `customers_status` VALUES (1, 'Active', '', 'green.gif', 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `customers_status` VALUES (2, 'Disable', '', 'red.gif', 2, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `customers_status` VALUES (3, 'Inactive', '', 'yellow.gif', 3, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);

-- ----------------------------
-- Table structure for delivery_orders
-- ----------------------------
DROP TABLE IF EXISTS `delivery_orders`;
CREATE TABLE `delivery_orders`  (
  `deliveryOrderId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderId` int(11) UNSIGNED NOT NULL,
  `deliveryOrderNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `shipmentDate` datetime NOT NULL,
  `deliveryDate` datetime NOT NULL,
  `customerId` int(11) UNSIGNED NOT NULL,
  `customerName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerDisplay` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sourceLocationId` int(11) UNSIGNED NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`deliveryOrderId`) USING BTREE,
  INDEX `delivery_orders_customerId_foreign`(`customerId`) USING BTREE,
  INDEX `delivery_orders_salesOrderId_foreign`(`salesOrderId`) USING BTREE,
  INDEX `delivery_orders_sourceLocationId_foreign`(`sourceLocationId`) USING BTREE,
  INDEX `IDXdeliveryOrderId`(`deliveryOrderId`) USING BTREE,
  CONSTRAINT `delivery_orders_customerId_foreign` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `delivery_orders_salesOrderId_foreign` FOREIGN KEY (`salesOrderId`) REFERENCES `sales_orders` (`salesOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `delivery_orders_sourceLocationId_foreign` FOREIGN KEY (`sourceLocationId`) REFERENCES `locations` (`locationId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of delivery_orders
-- ----------------------------

-- ----------------------------
-- Table structure for delivery_orders_details
-- ----------------------------
DROP TABLE IF EXISTS `delivery_orders_details`;
CREATE TABLE `delivery_orders_details`  (
  `deliveryOrderDetailId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deliveryOrderId` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `salesOrderDetailId` int(11) UNSIGNED NOT NULL,
  `ordered` int(11) NOT NULL,
  `delivered` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sort` int(3) UNSIGNED NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`deliveryOrderDetailId`) USING BTREE,
  INDEX `delivery_orders_details_deliveryOrderId_foreign`(`deliveryOrderId`) USING BTREE,
  INDEX `delivery_orders_details_salesOrderDetailId_foreign`(`salesOrderDetailId`) USING BTREE,
  INDEX `IDXpackageDetailsId`(`deliveryOrderDetailId`) USING BTREE,
  CONSTRAINT `delivery_orders_details_deliveryOrderId_foreign` FOREIGN KEY (`deliveryOrderId`) REFERENCES `delivery_orders` (`deliveryOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `delivery_orders_details_salesOrderDetailId_foreign` FOREIGN KEY (`salesOrderDetailId`) REFERENCES `sales_orders_details` (`salesOrderDetailId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of delivery_orders_details
-- ----------------------------

-- ----------------------------
-- Table structure for delivery_orders_details_temp
-- ----------------------------
DROP TABLE IF EXISTS `delivery_orders_details_temp`;
CREATE TABLE `delivery_orders_details_temp`  (
  `deliveryOrderDetailId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `productId` int(11) UNSIGNED NOT NULL,
  `salesOrderDetailId` int(11) UNSIGNED NOT NULL,
  `ordered` int(11) NOT NULL,
  `delivered` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`deliveryOrderDetailId`) USING BTREE,
  INDEX `delivery_orders_details_temp_salesOrderDetailId_foreign`(`salesOrderDetailId`) USING BTREE,
  INDEX `IDXpackageDetailsId`(`deliveryOrderDetailId`) USING BTREE,
  CONSTRAINT `delivery_orders_details_temp_salesOrderDetailId_foreign` FOREIGN KEY (`salesOrderDetailId`) REFERENCES `sales_orders_details` (`salesOrderDetailId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2000000001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of delivery_orders_details_temp
-- ----------------------------

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `groupId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`groupId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100002 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (100001, 'Administrator', 'Full Access Application', 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);

-- ----------------------------
-- Table structure for groups_roles
-- ----------------------------
DROP TABLE IF EXISTS `groups_roles`;
CREATE TABLE `groups_roles`  (
  `groupRolesId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupId` int(11) UNSIGNED NOT NULL,
  `menuId` int(11) UNSIGNED NOT NULL,
  `view` int(1) NOT NULL,
  `created` int(1) NOT NULL,
  `updated` int(1) NOT NULL,
  `cancelled` int(1) NOT NULL,
  `deleted` int(1) NOT NULL,
  `printed` int(1) NOT NULL,
  `downloaded` int(1) NOT NULL,
  `closed` int(1) NOT NULL,
  `verified` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`groupRolesId`) USING BTREE,
  INDEX `groups_roles_groupId_foreign`(`groupId`) USING BTREE,
  INDEX `groups_roles_menuId_foreign`(`menuId`) USING BTREE,
  CONSTRAINT `groups_roles_groupId_foreign` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `groups_roles_menuId_foreign` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100014 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups_roles
-- ----------------------------
INSERT INTO `groups_roles` VALUES (100001, 100001, 100001, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100002, 100001, 100002, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100003, 100001, 100003, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100004, 100001, 100004, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100005, 100001, 100005, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100006, 100001, 100006, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `groups_roles` VALUES (100007, 100001, 100009, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100008, 100001, 100010, 1, 1, 1, 0, 1, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100009, 100001, 100011, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100010, 100001, 100013, 1, 1, 1, 0, 1, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100011, 100001, 100012, 1, 1, 1, 0, 1, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100012, 100001, 100007, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', NULL);
INSERT INTO `groups_roles` VALUES (100013, 100001, 100008, 1, 1, 1, 0, 1, 0, 0, 0, 0, '', NULL);

-- ----------------------------
-- Table structure for location_stock
-- ----------------------------
DROP TABLE IF EXISTS `location_stock`;
CREATE TABLE `location_stock`  (
  `locationStockId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `locationId` int(11) UNSIGNED NOT NULL,
  `locationName` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `stock` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(11) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`locationStockId`) USING BTREE,
  UNIQUE INDEX `unique_index`(`locationId`, `productId`) USING BTREE,
  INDEX `location_stock_productId_foreign`(`productId`) USING BTREE,
  CONSTRAINT `location_stock_locationId_foreign` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `location_stock_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of location_stock
-- ----------------------------

-- ----------------------------
-- Table structure for location_transfers
-- ----------------------------
DROP TABLE IF EXISTS `location_transfers`;
CREATE TABLE `location_transfers`  (
  `locationTransferId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reffNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `transferDate` datetime NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sourceLocationId` int(11) UNSIGNED NOT NULL,
  `sourceLocationName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `destinationLocationId` int(11) UNSIGNED NOT NULL,
  `destinationLocationName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`locationTransferId`) USING BTREE,
  INDEX `location_transfers_sourceLocationId_foreign`(`sourceLocationId`) USING BTREE,
  INDEX `location_transfers_destinationLocationId_foreign`(`destinationLocationId`) USING BTREE,
  INDEX `IDXlocationTransferId`(`locationTransferId`) USING BTREE,
  CONSTRAINT `location_transfers_destinationLocationId_foreign` FOREIGN KEY (`destinationLocationId`) REFERENCES `locations` (`locationId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `location_transfers_sourceLocationId_foreign` FOREIGN KEY (`sourceLocationId`) REFERENCES `locations` (`locationId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of location_transfers
-- ----------------------------

-- ----------------------------
-- Table structure for location_transfers_details
-- ----------------------------
DROP TABLE IF EXISTS `location_transfers_details`;
CREATE TABLE `location_transfers_details`  (
  `locationTransferDetailId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `locationTransferId` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productType` int(2) NOT NULL,
  `priceCost` decimal(10, 2) NOT NULL,
  `priceSell` decimal(10, 2) NOT NULL,
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(11) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sourceStock` int(11) NOT NULL,
  `destinationStock` int(11) NOT NULL,
  `transferQuantity` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`locationTransferDetailId`) USING BTREE,
  INDEX `location_transfers_details_locationTransferId_foreign`(`locationTransferId`) USING BTREE,
  INDEX `location_transfers_details_productId_foreign`(`productId`) USING BTREE,
  INDEX `IDXinputBy`(`inputBy`) USING BTREE,
  CONSTRAINT `location_transfers_details_locationTransferId_foreign` FOREIGN KEY (`locationTransferId`) REFERENCES `location_transfers` (`locationTransferId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `location_transfers_details_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of location_transfers_details
-- ----------------------------

-- ----------------------------
-- Table structure for location_transfers_details_temp
-- ----------------------------
DROP TABLE IF EXISTS `location_transfers_details_temp`;
CREATE TABLE `location_transfers_details_temp`  (
  `locationTransferDetailId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `productId` int(11) UNSIGNED NOT NULL,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productType` int(2) NOT NULL,
  `priceCost` decimal(10, 2) NOT NULL,
  `priceSell` decimal(10, 2) NOT NULL,
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(11) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sourceStock` int(11) NOT NULL,
  `destinationStock` int(11) NOT NULL,
  `transferQuantity` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`locationTransferDetailId`) USING BTREE,
  INDEX `location_transfers_details_temp_productId_foreign`(`productId`) USING BTREE,
  INDEX `IDXinputBy`(`inputBy`) USING BTREE,
  CONSTRAINT `location_transfers_details_temp_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2000000001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of location_transfers_details_temp
-- ----------------------------

-- ----------------------------
-- Table structure for locations
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations`  (
  `locationId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `locationName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`locationId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of locations
-- ----------------------------

-- ----------------------------
-- Table structure for log_login
-- ----------------------------
DROP TABLE IF EXISTS `log_login`;
CREATE TABLE `log_login`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ipAddress` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `computer` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `userId` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `userName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `version` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_login
-- ----------------------------
INSERT INTO `log_login` VALUES (1, '127.0.0.1', 'DESKTOP-K11SN6Q', '100001', 'demo', '20221009', '2023-09-03 14:27:24');
INSERT INTO `log_login` VALUES (2, '127.0.0.1', 'DESKTOP-K11SN6Q', '100001', 'demo', '20221009', '2023-09-03 19:10:23');
INSERT INTO `log_login` VALUES (3, '127.0.0.1', 'DESKTOP-K11SN6Q', '100001', 'demo', '20221009', '2023-09-03 19:41:02');
INSERT INTO `log_login` VALUES (4, '127.0.0.1', 'DESKTOP-K11SN6Q', '100001', 'demo', '20221009', '2023-12-03 21:12:39');
INSERT INTO `log_login` VALUES (5, '127.0.0.1', 'DESKTOP-K11SN6Q', '100001', 'demo', '20221009', '2025-03-18 20:23:11');

-- ----------------------------
-- Table structure for log_users
-- ----------------------------
DROP TABLE IF EXISTS `log_users`;
CREATE TABLE `log_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `method` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `userId` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_users
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `menuId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menuPid` int(11) NOT NULL,
  `menuTypeId` int(11) UNSIGNED NOT NULL,
  `menu` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `urlType` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `menuLevel` int(2) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `menuOrder` int(6) NOT NULL,
  `statusId` int(2) NOT NULL,
  `view` int(1) NOT NULL,
  `created` int(1) NOT NULL,
  `updated` int(1) NOT NULL,
  `cancelled` int(1) NOT NULL,
  `deleted` int(1) NOT NULL,
  `printed` int(1) NOT NULL,
  `downloaded` int(1) NOT NULL,
  `closed` int(1) NOT NULL,
  `verified` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`menuId`) USING BTREE,
  INDEX `menu_menuTypeId_foreign`(`menuTypeId`) USING BTREE,
  CONSTRAINT `menu_menuTypeId_foreign` FOREIGN KEY (`menuTypeId`) REFERENCES `menu_type` (`menuTypeId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100014 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (100001, 0, 100001, 'DASHBOARD', '-', '-', '1', 1, 'DASHBOARD', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100002, 100001, 100001, 'SETTING', '-', '-', '1', 2, 'SETTING', 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100003, 100002, 100001, 'SETTING USERS', 'users.png', 'users/manage', '1', 3, 'SETTING USERS', 7, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100004, 100002, 100001, 'SETTING GROUPS', 'group.png', 'groups/manage', '1', 3, 'SETTING GROUPS', 8, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100005, 100002, 100001, 'SETTING PERMISSIONS', 'permission.png', 'perm/manage', '1', 3, 'SETTING PERMISSIONS', 9, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100006, 100002, 100001, 'SETTING MENU', 'menu.png', 'menu/manage', '1', 3, 'SETTING MENU', 10, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100007, 100001, 100001, 'TOOL', 'general.png', '-', '1', 2, 'TOOL', 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100008, 100007, 100001, 'HISTORY LOGIN', 'history.png', 'logLogin/manage', '1', 3, 'HISTORY LOGIN', 12, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100009, 100001, 100001, 'SALES ORDER', 'customer.png', '-', '1', 2, 'SALES ORDER', 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100010, 100009, 100001, 'CUSTOMER', 'customer.png', 'customers/manage', '1', 5, 'CUSTOMER', 7, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100011, 100001, 100001, 'MASTER DATA', '-', '-', '1', 2, 'MASTER DATA', 7, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100012, 100011, 100001, 'PRODUCT ITEMS', 'guide.png', 'products/manage', '1', 3, 'PRODUCT ITEMS', 3, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');
INSERT INTO `menu` VALUES (100013, 100011, 100001, 'LOCATION', 'customer.png', 'location/manage', '1', 3, 'LOCATION', 2, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, '100001', '2023-09-03 14:26:40');

-- ----------------------------
-- Table structure for menu_type
-- ----------------------------
DROP TABLE IF EXISTS `menu_type`;
CREATE TABLE `menu_type`  (
  `menuTypeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`menuTypeId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100004 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu_type
-- ----------------------------
INSERT INTO `menu_type` VALUES (100001, 'MENU PRIMARY', '100001', '2023-09-03 14:26:40', '', NULL);
INSERT INTO `menu_type` VALUES (100002, 'TOP MENU', '100001', '2023-09-03 14:26:40', '', NULL);
INSERT INTO `menu_type` VALUES (100003, 'MENU BLOG', '100001', '2023-09-03 14:26:40', '', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2022-08-08-101545', 'App\\Database\\Migrations\\AddTableGroups', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (2, '2022-08-08-101546', 'App\\Database\\Migrations\\PaymentTerms', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (3, '2022-08-08-101547', 'App\\Database\\Migrations\\AddTableCustomersStatus', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (4, '2022-08-08-101580', 'App\\Database\\Migrations\\AddTableUsers', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (5, '2022-08-08-103208', 'App\\Database\\Migrations\\AddTableRepresentative', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (6, '2022-08-08-103209', 'App\\Database\\Migrations\\AddTableSite', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (7, '2022-08-08-103637', 'App\\Database\\Migrations\\AddTableLogLogin', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (8, '2022-08-08-103655', 'App\\Database\\Migrations\\AddTableLogUsers', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (9, '2022-08-08-103705', 'App\\Database\\Migrations\\AddTableMenuType', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (10, '2022-08-08-103707', 'App\\Database\\Migrations\\AddTableMenu', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (11, '2022-08-12-103719', 'App\\Database\\Migrations\\AddTableGroupRoles', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (12, '2022-08-13-104644', 'App\\Database\\Migrations\\AddTableAutoNumber', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (13, '2022-08-15-105721', 'App\\Database\\Migrations\\AddTableCustomers', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (14, '2022-08-15-123736', 'App\\Database\\Migrations\\AddTableProducts', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (15, '2022-08-16-106103', 'App\\Database\\Migrations\\AddTableCustomersAddress', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (16, '2022-08-19-170132', 'App\\Database\\Migrations\\AddTableLocation', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (17, '2022-08-20-083002', 'App\\Database\\Migrations\\AddTableSalesOrders', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (18, '2022-08-20-083008', 'App\\Database\\Migrations\\AddTableSalesOrdersDetails', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (19, '2022-08-20-083008', 'App\\Database\\Migrations\\AddTableSalesOrdersDetailsTemp', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (20, '2022-08-20-083424', 'App\\Database\\Migrations\\AddTableSalesOrdersAddress', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (21, '2022-08-20-083525', 'App\\Database\\Migrations\\AddTableSalesOrdersAmount', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (22, '2022-08-20-173424', 'App\\Database\\Migrations\\AddTableApprovals', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (23, '2022-08-28-173424', 'App\\Database\\Migrations\\AddTableLocationTransfers', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (24, '2022-08-28-173435', 'App\\Database\\Migrations\\AddTableLocationTransferDetails', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (25, '2022-08-30-183435', 'App\\Database\\Migrations\\AddTableLocationTransferDetailsTemp', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (26, '2022-08-31-041406', 'App\\Database\\Migrations\\AddTableLocationStock', 'default', 'App', 1693631379, 1);
INSERT INTO `migrations` VALUES (27, '2022-09-06-033547', 'App\\Database\\Migrations\\AddTablePackages', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (28, '2022-09-06-033552', 'App\\Database\\Migrations\\AddTablePackagesDetails', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (29, '2022-09-06-045755', 'App\\Database\\Migrations\\AddTablePackagesDetailsTemp', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (30, '2022-09-11-082908', 'App\\Database\\Migrations\\AddTableDeliveryOrders', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (31, '2022-09-11-082917', 'App\\Database\\Migrations\\AddTableDeliveryOrdersDetails', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (32, '2022-09-11-082920', 'App\\Database\\Migrations\\AddTableDeliveryOrdersDetailsTemp', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (33, '2022-10-02-124420', 'App\\Database\\Migrations\\AddTableAdjustments', 'default', 'App', 1693631380, 1);
INSERT INTO `migrations` VALUES (34, '2022-10-02-124427', 'App\\Database\\Migrations\\AddTableAdjustmentsDetails', 'default', 'App', 1693631380, 1);

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages`  (
  `packageId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderId` int(11) UNSIGNED NOT NULL,
  `ordered` int(11) NOT NULL,
  `quantityToPack` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`packageId`) USING BTREE,
  INDEX `packages_salesOrderId_foreign`(`salesOrderId`) USING BTREE,
  INDEX `IDXpackageId`(`packageId`) USING BTREE,
  CONSTRAINT `packages_salesOrderId_foreign` FOREIGN KEY (`salesOrderId`) REFERENCES `sales_orders` (`salesOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of packages
-- ----------------------------

-- ----------------------------
-- Table structure for packages_details
-- ----------------------------
DROP TABLE IF EXISTS `packages_details`;
CREATE TABLE `packages_details`  (
  `packageDetailId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `packageId` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `salesOrderDetailId` int(11) UNSIGNED NOT NULL,
  `ordered` int(11) NOT NULL,
  `quantityToPack` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`packageDetailId`) USING BTREE,
  INDEX `packages_details_packageId_foreign`(`packageId`) USING BTREE,
  INDEX `packages_details_salesOrderDetailId_foreign`(`salesOrderDetailId`) USING BTREE,
  INDEX `IDXpackageDetailsId`(`packageDetailId`) USING BTREE,
  CONSTRAINT `packages_details_packageId_foreign` FOREIGN KEY (`packageId`) REFERENCES `packages` (`packageId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `packages_details_salesOrderDetailId_foreign` FOREIGN KEY (`salesOrderDetailId`) REFERENCES `sales_orders_details` (`salesOrderDetailId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of packages_details
-- ----------------------------

-- ----------------------------
-- Table structure for packages_details_temp
-- ----------------------------
DROP TABLE IF EXISTS `packages_details_temp`;
CREATE TABLE `packages_details_temp`  (
  `packageDetailId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `productId` int(11) UNSIGNED NOT NULL,
  `salesOrderDetailId` int(11) UNSIGNED NOT NULL,
  `ordered` int(11) NOT NULL,
  `quantityToPack` int(11) NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`packageDetailId`) USING BTREE,
  INDEX `packages_details_temp_salesOrderDetailId_foreign`(`salesOrderDetailId`) USING BTREE,
  INDEX `IDXpackageDetailsId`(`packageDetailId`) USING BTREE,
  CONSTRAINT `packages_details_temp_salesOrderDetailId_foreign` FOREIGN KEY (`salesOrderDetailId`) REFERENCES `sales_orders_details` (`salesOrderDetailId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of packages_details_temp
-- ----------------------------

-- ----------------------------
-- Table structure for payment_terms
-- ----------------------------
DROP TABLE IF EXISTS `payment_terms`;
CREATE TABLE `payment_terms`  (
  `paymentTermId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `termName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `numberOfDay` int(12) NOT NULL,
  `statusId` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`paymentTermId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100007 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_terms
-- ----------------------------
INSERT INTO `payment_terms` VALUES (100001, 'Due on reciept', 0, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `payment_terms` VALUES (100002, 'Due end of the month', 0, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `payment_terms` VALUES (100003, 'Net 15', 15, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `payment_terms` VALUES (100004, 'Net 45', 45, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `payment_terms` VALUES (100005, 'Net 60', 45, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);
INSERT INTO `payment_terms` VALUES (100006, 'Net 90', 90, 1, '100001', '2023-09-03 14:26:40', '', NULL, '', NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `productId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productType` int(2) NOT NULL,
  `priceCost` decimal(10, 2) NOT NULL,
  `priceSell` decimal(10, 2) NOT NULL,
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(11) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `remark` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(11) UNSIGNED NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`productId`) USING BTREE,
  INDEX `IDXproductId`(`productId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------

-- ----------------------------
-- Table structure for representative
-- ----------------------------
DROP TABLE IF EXISTS `representative`;
CREATE TABLE `representative`  (
  `representativeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `representative` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`representativeId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of representative
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders`;
CREATE TABLE `sales_orders`  (
  `salesOrderId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `salesOrderDate` datetime NULL DEFAULT NULL,
  `expectedShipmentDate` datetime NULL DEFAULT NULL,
  `shipmentDate` datetime NULL DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerId` int(11) UNSIGNED NOT NULL,
  `customerName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customerDisplay` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `representativeId` int(11) UNSIGNED NULL DEFAULT NULL,
  `representative` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `totalAmount` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `paymentTermId` int(11) UNSIGNED NOT NULL,
  `termName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`salesOrderId`) USING BTREE,
  INDEX `sales_orders_customerId_foreign`(`customerId`) USING BTREE,
  INDEX `sales_orders_paymentTermId_foreign`(`paymentTermId`) USING BTREE,
  INDEX `sales_orders_representativeId_foreign`(`representativeId`) USING BTREE,
  CONSTRAINT `sales_orders_customerId_foreign` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_paymentTermId_foreign` FOREIGN KEY (`paymentTermId`) REFERENCES `payment_terms` (`paymentTermId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_representativeId_foreign` FOREIGN KEY (`representativeId`) REFERENCES `representative` (`representativeId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders_address
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders_address`;
CREATE TABLE `sales_orders_address`  (
  `salesOrdersAddressId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderId` int(11) UNSIGNED NOT NULL,
  `customerId` int(11) UNSIGNED NOT NULL,
  `customerAddressTypeId` int(11) NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `zipCode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`salesOrdersAddressId`) USING BTREE,
  INDEX `sales_orders_address_customerId_foreign`(`customerId`) USING BTREE,
  INDEX `sales_orders_address_salesOrderId_foreign`(`salesOrderId`) USING BTREE,
  CONSTRAINT `sales_orders_address_customerId_foreign` FOREIGN KEY (`customerId`) REFERENCES `customers` (`customerId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_address_salesOrderId_foreign` FOREIGN KEY (`salesOrderId`) REFERENCES `sales_orders` (`salesOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders_address
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders_amount
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders_amount`;
CREATE TABLE `sales_orders_amount`  (
  `salesOrderAmountId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderId` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL DEFAULT 1,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`salesOrderAmountId`) USING BTREE,
  INDEX `sales_orders_amount_salesOrderId_foreign`(`salesOrderId`) USING BTREE,
  CONSTRAINT `sales_orders_amount_salesOrderId_foreign` FOREIGN KEY (`salesOrderId`) REFERENCES `sales_orders` (`salesOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders_amount
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders_details
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders_details`;
CREATE TABLE `sales_orders_details`  (
  `salesOrderDetailId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesOrderId` int(11) UNSIGNED NOT NULL,
  `productId` int(11) UNSIGNED NOT NULL,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productType` int(2) NOT NULL,
  `priceCost` decimal(10, 2) NOT NULL,
  `priceSell` decimal(10, 2) NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `delivery` int(11) NOT NULL DEFAULT 0,
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(11) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL,
  `sort` int(3) UNSIGNED NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`salesOrderDetailId`) USING BTREE,
  INDEX `sales_orders_details_salesOrderId_foreign`(`salesOrderId`) USING BTREE,
  INDEX `sales_orders_details_productId_foreign`(`productId`) USING BTREE,
  CONSTRAINT `sales_orders_details_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_details_salesOrderId_foreign` FOREIGN KEY (`salesOrderId`) REFERENCES `sales_orders` (`salesOrderId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18446744073709551615 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders_details
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders_details_temp
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders_details_temp`;
CREATE TABLE `sales_orders_details_temp`  (
  `salesOrderDetailId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `productId` int(11) UNSIGNED NOT NULL,
  `productNumber` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `productType` int(2) NOT NULL,
  `priceCost` decimal(10, 2) NOT NULL,
  `priceSell` decimal(10, 2) NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(11) NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(2) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`salesOrderDetailId`) USING BTREE,
  INDEX `sales_orders_details_temp_productId_foreign`(`productId`) USING BTREE,
  CONSTRAINT `sales_orders_details_temp_productId_foreign` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2000000001 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders_details_temp
-- ----------------------------

-- ----------------------------
-- Table structure for site
-- ----------------------------
DROP TABLE IF EXISTS `site`;
CREATE TABLE `site`  (
  `siteId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `site` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `statusId` int(1) NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`siteId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of site
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `userId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `groupId` int(11) UNSIGNED NOT NULL,
  `statusId` int(2) NOT NULL,
  `changePassword` int(1) NOT NULL,
  `deptId` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `positionId` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lastLogin` datetime NULL DEFAULT NULL,
  `lastUrl` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `site` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `inputDate` datetime NULL DEFAULT NULL,
  `updateBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `updateDate` datetime NULL DEFAULT NULL,
  `deleteBy` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `deleteDate` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`userId`) USING BTREE,
  INDEX `users_groupId_foreign`(`groupId`) USING BTREE,
  CONSTRAINT `users_groupId_foreign` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 100002 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (100001, 'demo', 'demo application', 'demo@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 100001, 1, 1, '', '', '2025-03-18 20:23:11', '', '', '100001', '2023-09-03 14:26:40', '', '2025-03-18 20:23:11', '', NULL);

SET FOREIGN_KEY_CHECKS = 1;
